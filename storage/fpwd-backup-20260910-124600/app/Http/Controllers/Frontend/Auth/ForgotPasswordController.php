<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Frontend\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * "Forgot password" step one: confirm the address belongs to an account.
 *
 * No code is emailed - the customer is taken straight to the new-password form.
 * The only check is that the account exists, so an unregistered address is told
 * so rather than being silently accepted.
 */
class ForgotPasswordController extends Controller
{
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

        if (!$user) {
            return back()->withInput()
                ->withErrors(['email' => __('No account is registered with that email address. Please check the address or create a new account.')]);
        }

        if ($user->is_suspended) {
            return back()->withInput()
                ->withErrors(['email' => __('This account has been suspended. Please contact our support team.')]);
        }

        // Carry the confirmed address forward so the reset screen cannot be used
        // to change the password of some *other* account.
        $request->session()->put('password_reset_email', $user->email);

        return redirect()->route('customer.password.reset')
            ->with('status', __('Account found. Please set a new password below.'));
    }
}
