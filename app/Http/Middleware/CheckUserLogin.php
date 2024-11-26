<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRedirectMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
            return redirect()->route('login');
        }

        // Người dùng đã đăng nhập, cho phép tiếp tục truy cập
        return $next($request);
    }
}
