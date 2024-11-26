<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // Kiểm tra nếu người dùng chưa xác thực hoặc không phải là admin
        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập
        }

        return $next($request);
    }
}
