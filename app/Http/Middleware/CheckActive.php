<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckActive
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
            if ($user->is_active == 0) {
                $message = 'Your account in not active.';
                auth('customer')->logout();
                return redirect()->route('customer.login')->withErrors($message);
            }
        }
        return $next($request);
    }
}
