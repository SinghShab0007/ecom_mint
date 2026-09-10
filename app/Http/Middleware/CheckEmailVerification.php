<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckEmailVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Route::is('verification.verify') || $request->is('logout')){
            return $next($request);
        }

        if (auth('customer')->check()){
            $user = auth('customer')->user();
            if ($user->email_verified_at == null) {
                return redirect()->route('customer.verification.notice');
            }
        }

        return $next($request);
    }
}
