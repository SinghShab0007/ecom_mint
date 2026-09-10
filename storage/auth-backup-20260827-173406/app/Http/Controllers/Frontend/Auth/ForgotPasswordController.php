<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use App\Models\Frontend\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return View
     */
    public function showLinkRequestForm(): View
    {
        return view('frontend.auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request,[
          'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => __('We could not find an account with that email address.'),
        ]);

        $user = User::query()
            ->where('email',$request->email)
            ->orWhere('mobile',$request->email)
            ->first();

        if (!$user) {
            return back()->withInput()
                ->with('error', __('We could not find an account with that email address.'));
        }

        // Generate password reset verification code and expire date for
        // the verification code. The code and the expiry date will store in
        // database. The verification code won't work after the expiry date.
        $code = random_int(100000,999999);
        $expire = now()->addHour();

        $user->update(['verification_code'=>$code, 'verification_expire_at'=>$expire]);

        $data = [
            'code' => $code,
            'url' => url('customer/password/reset'),
        ];

        // Send after the response is flushed so the user is not left waiting on
        // SMTP, without needing a queue worker to be running.
        $email = $user->email;

        app()->terminating(function () use ($email, $data) {
            try {
                Mail::to($email)->send(new PasswordReset($data));
            } catch (\Throwable $e) {
                \Log::error('Password reset mail failed (customer): ' . $e->getMessage());
            }
        });

        return redirect()->route('customer.password.reset')
            ->with('reset_email', $user->email)
            ->with('status', __('A 6-digit verification code has been sent to :email. It is valid for 1 hour.', ['email' => $user->email]));
    }
}
