<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Frontend\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Customer registration.
 *
 * There is no email/OTP verification step: an account is usable the moment it
 * is created, and the customer is signed in straight away. Because nothing
 * verifies an address after the fact, email and mobile are unique outright
 * rather than "unique among verified rows".
 */
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
        return Validator::make($data, [
            'full_name' => ['required', 'string', 'max:255'],
            'mobile' => [
                'required',
                'digits:10',
                'regex:/^[6-9][0-9]{9}$/',
                'unique:users,mobile',
            ],
            'email' => [
                'required',
                'string',
                'email:rfc',
                'max:255',
                'unique:users,email',
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.email'    => __('Enter a valid email address.'),
            'email.unique'   => __('This email is already registered. Please log in instead.'),
            'mobile.unique'  => __('This mobile number is already registered. Please log in instead.'),
            'mobile.digits'  => __('Mobile number must be exactly 10 digits.'),
            'mobile.regex'   => __('Enter a valid 10-digit Indian mobile number starting with 6, 7, 8 or 9.'),
            'password.min'   => __('Password must be at least 8 characters.'),
            'password.confirmed' => __('The two passwords do not match.'),
        ]);
    }

    /** Split full name into the first/last columns the users table already has. */
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

        $user = User::query()->create([
            'first_name' => $names['first_name'],
            'last_name' => $names['last_name'],
            'address' => '',
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'username' => $this->uniqueUsernameFromEmail($data['email']),
            'password' => Hash::make($data['password']),
            'stop_email' => 0,
            // Live immediately - no admin approval and no OTP gate.
            'is_active' => 1,
            'is_suspended' => 0,
            'verification_code' => null,
            'verification_expire_at' => null,
        ]);

        // email_verified_at is not in the model's $fillable, so create() drops
        // it. Stamp it explicitly: with no OTP step there is nothing left to
        // verify, and leaving it null makes accounts look half-registered to any
        // Laravel feature that reads MustVerifyEmail.
        $user->forceFill(['email_verified_at' => now()])->save();

        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        auth()->guard('customer')->login($user);

        return redirect()->to(url('/'))->with(
            'status',
            __('Welcome to :app, :name! Your account is ready.', [
                'app' => config('app.name'),
                'name' => trim($user->first_name . ' ' . $user->last_name) ?: $user->username,
            ])
        );
    }
}
