<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Dùng cho các trang chỉ dành cho KHÁCH (/login, /register, quên mật khẩu...):
     * người đã đăng nhập thì chuyển thẳng về trang làm việc.
     * Nhờ đó controller không cần tự kiểm tra Auth::check().
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return redirect()->route('workspaces.index');
        }

        return $next($request);
    }
}
