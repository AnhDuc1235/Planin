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
     * - Chưa đăng nhập + request thường: chuyển tới /login và GHI NHỚ URL đích
     *   (redirect()->guest) để đăng nhập xong quay lại đúng trang.
     * - Chưa đăng nhập + request fetch/AJAX (Vue): trả 401 JSON thay vì redirect.
     * - Đã đăng nhập: cho đi tiếp.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.'], 401);
            }

            return redirect()->guest(route('login'))
                ->with('info', 'Vui lòng đăng nhập để tiếp tục.');
        }

        return $next($request);
    }
}
