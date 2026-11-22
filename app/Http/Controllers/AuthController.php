<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

/**
 * Xác thực: đăng nhập, đăng xuất, quên / đặt lại mật khẩu.
 * Controller chỉ nhận Request đã validate và gọi AuthService.
 * Việc chặn người đã đăng nhập vào /login do middleware 'check.guest' đảm nhiệm.
 */
class AuthController extends Controller
{
    public function __construct(private readonly AuthService $auth)
    {
    }

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->auth->attempt(
            $data['email'],
            $data['password'],
            $request->boolean('remember'),
            (string) $request->ip(),
        );

        // Quay lại URL đích đã bị CheckLogin chặn; không có thì vào trang làm việc.
        return redirect()->intended(route('workspaces.index'));
    }

    public function logout(): RedirectResponse
    {
        $this->auth->logout();

        return redirect()->route('home');
    }

    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(ForgotPasswordRequest $request): RedirectResponse
    {
        $status = $this->auth->sendResetLink($request->validated('email'));

        if ($status === Password::RESET_THROTTLED) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
        }

        // Thông báo chung cho cả trường hợp email không tồn tại (tránh dò email).
        return back()->with('status', 'Nếu email tồn tại trong hệ thống, chúng tôi đã gửi liên kết đặt lại mật khẩu.');
    }

    public function showResetPasswordForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $status = $this->auth->resetPassword($request->validated());

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
