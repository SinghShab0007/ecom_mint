<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $crud = [
        'create' => 'POST',
        'browse' => 'GET',
        'edit' => 'PUT',
        'delete' => 'DELETE'
    ];

    public function handle($request, Closure $next)
    {
        $info = [
            'key' => null,
            'route' => null
        ];
        try {
            $guard = Auth::getDefaultDriver();

            $info['key'] = array_search($request->method(), $this->crud) ?: '';
            $info['route'] = Request::segment(2);
            if ($info['route'] == null) $info['route'] = 'dashboard';
            if (Auth::user()->hasRole('super-admin') || auth($guard)->user()->hasPermissionTo($info['key'] . '_' . $info['route'], $guard)) {
                return $next($request);
            }
            Auth::logout();
            throw UnauthorizedException::forPermissions([$info['key'].'_'.$info['route']]);
        }catch (\Exception $exception){
            throw UnauthorizedException::forPermissions([$info['key'].'_'.$info['route']]);
        }
    }
}
