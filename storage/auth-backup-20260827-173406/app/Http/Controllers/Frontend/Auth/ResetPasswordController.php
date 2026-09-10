<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Frontend\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request)
    {
        return view('frontend.auth.passwords.reset');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules($request->email), $this->validationErrorMessages());

        $user = User::query()
            ->where('email',$request->email)
            ->where('verification_code',$request->verification_code)
            ->first();

        if(!$user){
            return redirect()->back()->withInput()
                ->with('error', __('That verification code is not valid for this email address.'));
        }

        if(!$user->verification_expire_at || $user->verification_expire_at < now()){
            return redirect()->back()->withInput()
                ->with('error', __('This verification code has expired. Please request a new one.'));
        }

        // Clear the code so it cannot be replayed to reset the password again.
        $user->forceFill([
            'password' => bcrypt($request->password),
            'verification_code' => null,
            'verification_expire_at' => null,
        ])->save();

        return redirect()->route('customer.login')
            ->with('status', __('Your password has been reset successfully. Please log in with your new password.'));
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules($email)
    {
        return [
            'verification_code' => [
                'required',
                Rule::exists('users')->where(function($q)use($email){
                    $q->where('email',$email);
                })],
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],
        ];
    }
}
