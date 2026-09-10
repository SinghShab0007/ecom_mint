<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use App\Models\Frontend\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

/**
 * "Forgot password" step one: confirm the account, then email a one-time code.
 *
 * An address with no account is sent to the register form rather than being
 * told nothing useful - mirroring how the login form treats unknown accounts.
 */
class ForgotPasswordController extends Controller
{
    /** How long an emailed reset code stays usable. */
    private const CODE_TTL_MINUTES = 15;

    public function showLinkRequestForm(): View
    {
        return view('frontend.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email:rfc'],
        ], [
            'email.required' => __('Please enter your email address.'),
            'email.email'    => __('Enter a valid email address.'),
        ]);

        $user = User::query()->where('email', $request->email)->first();

        // No account yet - point them at registration instead of a dead end.
        if (!$user) {
            return redirect()->route('customer.register')
                ->withInput(['email' => $request->email])
                ->with('error', __('No account is registered with :email. Please create your account first.', [
                    'email' => $request->email,
                ]));
        }

        if ($user->is_suspended) {
            return back()->withInput()
                ->withErrors(['email' => __('This account has been suspended. Please contact our support team.')]);
        }

        $code = (string) random_int(100000, 999999);

        $user->forceFill([
            'verification_code' => $code,
            'verification_expire_at' => now()->addMinutes(self::CODE_TTL_MINUTES),
        ])->save();

        $this->sendCode($user->email, $code);

        // Carries the confirmed address to the reset screen so the form cannot
        // be pointed at somebody else's account.
        $request->session()->put('password_reset_email', $user->email);

        return redirect()->route('customer.password.reset')
            ->with('status', __('We have emailed a 6-digit code to :email. It is valid for :mins minutes.', [
                'email' => $user->email,
                'mins'  => self::CODE_TTL_MINUTES,
            ]));
    }

    /**
     * Send after the response is flushed, so the customer is not left waiting
     * on SMTP and no queue worker is required.
     */
    private function sendCode(string $email, string $code): void
    {
        $data = ['code' => $code, 'url' => route('customer.password.reset')];

        app()->terminating(function () use ($email, $data) {
            try {
                Mail::to($email)->send(new PasswordReset($data));
            } catch (\Throwable $e) {
                Log::error('Password reset mail failed (customer): ' . $e->getMessage());
            }
        });
    }
}
