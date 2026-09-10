<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Providers\RouteServiceProvider;
use App\Models\Frontend\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:customer');
    }

    public function showRegisterForm()
    {
        return view('frontend.auth.register');
    }

    protected function validator(array $data)
    {
        // Only a *verified* account blocks the email/mobile. Otherwise someone who
        // closed the OTP screen could never register with their own address again.
        return Validator::make($data, [
            'full_name' => ['required', 'string', 'max:255'],
            'mobile' => [
                'required', 'digits:10', 'regex:/^[6-9][0-9]{9}$/',
                Rule::unique('users', 'mobile')->whereNotNull('email_verified_at'),
            ],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->whereNotNull('email_verified_at'),
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique' => __('This email is already registered. Please log in instead.'),
            'mobile.unique' => __('This mobile number is already registered. Please log in instead.'),
            'mobile.digits' => __('Mobile number must be exactly 10 digits.'),
            'mobile.regex' => __('Enter a valid 10-digit Indian mobile number.'),
        ]);
    }

    /**
     * Split full name into first + last for existing DB columns.
     */
    protected function splitFullName(string $fullName): array
    {
        $fullName = trim(preg_replace('/\s+/', ' ', $fullName));
        if ($fullName === '') {
            return ['first_name' => '', 'last_name' => ''];
        }
        $parts = preg_split('/\s+/', $fullName, 2);

        return [
            'first_name' => $parts[0] ?? '',
            'last_name' => $parts[1] ?? '',
        ];
    }

    protected function uniqueUsernameFromEmail(string $email): string
    {
        $local = Str::slug(Str::before($email, '@'), '_');
        if ($local === '' || strlen($local) < 2) {
            $local = 'user';
        }
        $username = $local;
        $n = 0;
        while (User::query()->where('username', $username)->exists()) {
            $username = $local . '_' . (++$n);
        }

        return $username;
    }

    protected function create(array $data)
    {
        $names = $this->splitFullName($data['full_name']);
        $username = $this->uniqueUsernameFromEmail($data['email']);
        $otp = (string) random_int(100000, 999999);

        return User::query()->create([
            'first_name' => $names['first_name'],
            'last_name' => $names['last_name'],
            'address' => '',
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'username' => $username,
            'password' => Hash::make($data['password']),
            'stop_email' => 0,
            'is_active' => 0,
            'is_suspended' => 0,
            'verification_code' => $otp,
            'verification_expire_at' => Carbon::now()->addMinutes(10),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $data = $request->all();

        // Re-use the row of a previous, never-verified attempt instead of failing
        // on the unique index.
        $user = User::query()
            ->whereNull('email_verified_at')
            ->where(function ($q) use ($data) {
                $q->where('email', $data['email'])->orWhere('mobile', $data['mobile']);
            })
            ->first();

        if ($user) {
            $names = $this->splitFullName($data['full_name']);

            $user->forceFill([
                'first_name' => $names['first_name'],
                'last_name' => $names['last_name'],
                'mobile' => $data['mobile'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'is_active' => 0,
                'verification_code' => (string) random_int(100000, 999999),
                'verification_expire_at' => Carbon::now()->addMinutes(10),
            ])->save();
        } else {
            $user = $this->create($data);
            event(new Registered($user));
        }

        $this->sendOtpEmail($user);

        $request->session()->put('pending_email_verification_user_id', $user->id);

        return redirect()->route('customer.verification.show')
            ->with('status', __('A 6-digit OTP has been sent to :email. Please enter it below to verify your account.', ['email' => $user->email]));
    }

    /**
     * Hand the OTP mail to the framework's "terminating" stage so SMTP runs
     * *after* the response has been flushed to the browser. The user gets an
     * instant redirect and no queue worker has to be running.
     */
    protected function sendOtpEmail(User $user): void
    {
        $email = $user->email;
        $code = $user->verification_code;
        $name = trim($user->first_name . ' ' . $user->last_name);

        app()->terminating(function () use ($email, $code, $name) {
            try {
                Mail::to($email)->send(new OtpMail($code, $name));
            } catch (\Throwable $e) {
                \Log::error('OTP mail send failed (customer): ' . $e->getMessage());
            }
        });
    }

    public function showVerifyForm(Request $request)
    {
        $userId = $request->session()->get('pending_email_verification_user_id');
        if (!$userId) {
            return redirect()->route('customer.register');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('customer.register');
        }

        return view('frontend.auth.verify-otp', [
            'email' => $user->email,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $userId = $request->session()->get('pending_email_verification_user_id');
        if (!$userId) {
            return redirect()->route('customer.register')
                ->withErrors(['otp' => __('Verification session expired. Please register again.')]);
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('customer.register')
                ->withErrors(['otp' => __('User not found.')]);
        }

        if (empty($user->verification_code) || $user->verification_code !== $request->otp) {
            return back()->withErrors(['otp' => __('Invalid OTP. Please try again.')]);
        }

        if ($user->verification_expire_at && Carbon::parse($user->verification_expire_at)->isPast()) {
            return back()->withErrors(['otp' => __('OTP has expired. Please request a new one.')]);
        }

        $user->forceFill([
            'verification_code' => null,
            'verification_expire_at' => null,
            'email_verified_at' => Carbon::now(),
            'is_active' => 1,
        ])->save();

        $request->session()->forget('pending_email_verification_user_id');

        auth()->guard('customer')->login($user);

        return redirect()->to(url('/'))
            ->with('status', __('Email verified successfully. Your account is now active — welcome to :app!', ['app' => config('app.name')]));
    }

    public function resendOtp(Request $request)
    {
        $userId = $request->session()->get('pending_email_verification_user_id');
        if (!$userId) {
            return redirect()->route('customer.register');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('customer.register');
        }

        $otp = (string) random_int(100000, 999999);
        $user->forceFill([
            'verification_code' => $otp,
            'verification_expire_at' => Carbon::now()->addMinutes(10),
        ])->save();

        $this->sendOtpEmail($user);

        return back()->with('status', __('A new OTP has been sent to :email.', ['email' => $user->email]));
    }
}
