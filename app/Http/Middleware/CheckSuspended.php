<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSuspended
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
        if (auth('customer')->check()){
            $user = auth('customer')->user();
            if ($user->is_suspended == 1) {
                $message = 'Your account has been suspended.';
                auth('customer')->logout();
                return redirect()->route('customer.login')->withErrors($message);
            }
        }
        return $next($request);
    }
}
