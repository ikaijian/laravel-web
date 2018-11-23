<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
//            利用 Request 的 is 方法来判断 URL
            $message = $request->is('register') ? '您已注册并已登录！' : '您已登陆，无需再次操作';
            session()->flash('info', $message);
            return redirect('/');
        }

        return $next($request);
    }
}
