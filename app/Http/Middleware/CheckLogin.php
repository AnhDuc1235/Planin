<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Middleware kiểm tra Session đăng nhập:
     * - Nếu chưa đăng nhập: đá về trang chủ ('/')
     * - Nếu đã đăng nhập: cho phép tiếp tục vào trang board
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
