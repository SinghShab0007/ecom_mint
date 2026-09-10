<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Frontend\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

/**
 * "Forgot password" step two: set the new password.
 *
 * The address is taken from the session entry written by
 * ForgotPasswordController, not from the submitted form, so this endpoint
 * cannot be posted directly to reset an arbitrary account.
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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.min' => __('Password must be at least 8 characters.'),
            'password.confirmed' => __('The two passwords do not match.'),
        ]);

        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            $request->session()->forget('password_reset_email');

            return redirect()->route('customer.password.email')
                ->withErrors(['email' => __('No account is registered with that email address.')]);
        }

        $user->forceFill([
            'password' => bcrypt($request->password),
            'verification_code' => null,
            'verification_expire_at' => null,
        ])->save();

        // Burn the session entry so the same confirmation cannot be reused.
        $request->session()->forget('password_reset_email');

        return redirect()->route('customer.login')
            ->with('status', __('Your password has been updated. Please log in with your new password.'));
    }
}
