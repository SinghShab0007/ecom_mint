<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Frontend\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

/**
 * "Forgot password" step two: prove ownership with the emailed code, then set
 * the new password.
 *
 * The address comes from the session entry written in step one, never from the
 * submitted form, so this endpoint cannot be posted directly against another
 * account. The code is single-use.
 */
class ResetPasswordController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request)
    {
        if (!$request->session()->has('password_reset_email')) {
            return redirect()->route('customer.password.email')
                ->withErrors(['email' => __('Please confirm your email address first.')]);
        }

        return view('frontend.auth.passwords.reset', [
            'email' => $request->session()->get('password_reset_email'),
        ]);
    }

    public function reset(Request $request)
    {
        $email = $request->session()->get('password_reset_email');

        if (!$email) {
            return redirect()->route('customer.password.email')
                ->withErrors(['email' => __('Your reset session has expired. Please start again.')]);
        }

        $request->validate([
            'verification_code' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'verification_code.required' => __('Please enter the 6-digit code we emailed you.'),
            'verification_code.digits'   => __('The code is 6 digits long.'),
            'password.min'               => __('Password must be at least 8 characters.'),
            'password.confirmed'         => __('The two passwords do not match.'),
        ]);

        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            $request->session()->forget('password_reset_email');

            return redirect()->route('customer.password.email')
                ->withErrors(['email' => __('No account is registered with that email address.')]);
        }

        if (empty($user->verification_code) || !hash_equals((string) $user->verification_code, (string) $request->verification_code)) {
            return back()->withInput()
                ->withErrors(['verification_code' => __('That code is not correct. Please check the email and try again.')]);
        }

        if (!$user->verification_expire_at || $user->verification_expire_at < now()) {
            return back()->withInput()
                ->withErrors(['verification_code' => __('That code has expired. Please request a new one.')]);
        }

        // Clear the code so it cannot be replayed to reset the password twice.
        $user->forceFill([
            'password' => bcrypt($request->password),
            'verification_code' => null,
            'verification_expire_at' => null,
        ])->save();

        $request->session()->forget('password_reset_email');

        return redirect()->route('customer.login')
            ->with('status', __('Your password has been updated. Please log in with your new password.'));
    }
}
