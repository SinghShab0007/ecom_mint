<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\ApiUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function token(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = request(['email', 'password']);

        $user = ApiUser::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $createdToken = $user->createToken('Password Grant Client');
                $token = $createdToken->token;
                return response()->json([
                    'access_token' => $createdToken->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
                ]);
            } else {
                return response()->json([
                    'error' => 'Password mismatch',
                    'success' => 'false',
                ], 422);
            }
        } else {
            return response()->json([
                'error' => 'User does not exist',
                'success' => 'false',
            ], 422);
        }

    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = request(['email', 'password']);
        if ($token = auth('web')->attempt($credentials)){
            return response()->json([
                'success' => true,
                'status' => Response::HTTP_OK,
                'message' => 'You have successfully logged in',
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('web')->factory()->getTTL() * 60 * 3600,
                'data' => auth()->user(),
            ]);
        } else{
            return response()->json([
                'success' => false,
                'status' => Response::HTTP_OK,
                'message' => 'Incorrect email or password.'
            ]);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json([
            'success' => true,
            'status' => Response::HTTP_OK,
            'message' => 'Successfully Loaded',
            'data' => auth('api')->user()
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];

        return response()->json([
            'success' => true,
            'status' => Response::HTTP_OK,
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('customer')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('web')->factory()->getTTL() * 60
        ]);
    }
}
