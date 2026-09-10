<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Api\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:customer');
    }

    public function showRegisterForm()
    {
        return view('frontend.auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required','unique:users'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required','max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return Builder|Model
     */
    protected function create(array $data)
    {
        return User::query()->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'address' => '',
            'mobile' => $data['mobile'],
            'email' => $data['email']??'',
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'stop_email' => 0,
            'is_active' => 1,
            'is_suspended' => 0,
            'verification_code' => '',
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $this->validator($request->all())->validate();

        event(new Registered($customer = $this->create($request->all())));
        if ($customer) {
            $createdToken = $customer->createToken('Password Grant Customer');
            $token = $createdToken->token;
            return response()->json([
                'status' => 'Success',
                'message' => 'Registration Successful',
                'customer' => $customer->apiUserResponse(),
                'access_token' => $createdToken->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
            ],201);
        } else {
            return response()->json([
                'error' => 'User Registration Failed',
                'success' => 'false',
            ], 422);
        }
    }
}
