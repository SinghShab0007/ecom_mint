<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use App\Models\Frontend\Seller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class SellerForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('backend.pages.auth.seller.passwords.email');
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
            'email' => 'required|email|exists:admins,email'
        ]);

        $code = random_int(100000,999999);
        $expire = now()->addHour();
        $user = Seller::where('email',$request->email)
                ->first();

        $user->update([
            'verification_code' => $code, 
            'verification_expire_at' => $expire
        ]);

        $url = url('seller/verify/reset/code');

        $data = [
            'code' => $code,
            'url' => $url
        ];

        try{
            Mail::to($request->email)->send(new PasswordReset($data));
        }catch (\Exception $exception){
            return back()->withErrors(['error' => $exception->getMessage()]);
        }

        if(Mail::failures() != 0) {
            return back()->with('success', 'Success! password reset link has been sent to your email');
        }
        return back()->with('failed', 'Failed! there is some issue with email provider');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('seller');
    }

    /**
     * Returns the password broker for sellers
     *
     * @return broker
     */
    protected function broker()
    {
        return Password::broker('sellers');
    }

}
