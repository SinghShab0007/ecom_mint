<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use function PHPUnit\Framework\fileExists;

class IsNotInstalled
{
    public function handle(Request $request, Closure $next)
    {
        if(\Illuminate\Support\Facades\Request::is('/'))
        {
            if(!file_exists(storage_path('installed'))){
                return redirect('install');
            }
        }

        return $next($request);
    }
}
