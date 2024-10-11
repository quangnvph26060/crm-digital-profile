<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLoginAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('admin')->check()) {
            $user = auth('admin')->user();

            if (!$user->status) {
                auth('admin')->logout();

                return redirect()->route('login-admin')->with('error', 'Tài khoản của bạn bị khóa');
            } else {
                return $next($request);
            }
        } else {
            return redirect()->route('login-admin')->with('error', 'Yêu cầu đăng nhập');
        }
    }
}
