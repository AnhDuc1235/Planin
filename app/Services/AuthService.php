<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Nghiệp vụ XÁC THỰC: đăng nhập, đăng xuất, quên / đặt lại mật khẩu.
 * (Tạo và sửa tài khoản nằm ở AccountService.)
 */
class AuthService
{
    public const MAX_LOGIN_ATTEMPTS = 5;
    public const LOGIN_DECAY_SECONDS = 60;

    /**
     * Đăng nhập bằng session. Sai thông tin hoặc bị khóa tạm -> ném ValidationException
     * (Laravel tự quay lại form kèm lỗi 'login_error' và email đã nhập).
     */
    public function attempt(string $email, string $password, bool $remember, string $ip): void
    {
        $key = $this->throttleKey($email, $ip);

        if (RateLimiter::tooManyAttempts($key, self::MAX_LOGIN_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'login_error' => "Bạn đã đăng nhập sai quá nhiều lần. Vui lòng thử lại sau {$seconds} giây.",
            ]);
        }

        if (! Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            RateLimiter::hit($key, self::LOGIN_DECAY_SECONDS);

            throw ValidationException::withMessages([
                'login_error' => 'Email hoặc mật khẩu không chính xác.',
            ]);
        }

        RateLimiter::clear($key);
        Session::regenerate(); // chống session fixation
    }

    /** Đăng nhập thẳng cho một user đã có (vd. ngay sau khi đăng ký). */
    public function loginUser(User $user, bool $remember = false): void
    {
        Auth::login($user, $remember);
        Session::regenerate();
    }

    public function logout(): void
    {
        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();
    }

    /**
     * Gửi liên kết đặt lại mật khẩu (dev: MAIL_MAILER=log -> xem storage/logs/laravel.log).
     *
     * @return string hằng Password::RESET_LINK_SENT | INVALID_USER | RESET_THROTTLED
     */
    public function sendResetLink(string $email): string
    {
        return Password::sendResetLink(['email' => $email]);
    }

    /**
     * Đặt lại mật khẩu bằng token trong email.
     *
     * @param  array{email: string, token: string, password: string}  $data
     * @return string hằng Password::PASSWORD_RESET | INVALID_TOKEN | INVALID_USER | RESET_THROTTLED
     */
    public function resetPassword(array $data): string
    {
        return Password::reset(
            [
                'email' => $data['email'],
                'token' => $data['token'],
                'password' => $data['password'],
            ],
            function (User $user, string $password): void {
                // Cast 'hashed' của model tự băm mật khẩu.
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60), // vô hiệu hóa "ghi nhớ đăng nhập" cũ
                ])->save();

                event(new PasswordReset($user));
            }
        );
    }

    private function throttleKey(string $email, string $ip): string
    {
        return Str::transliterate(Str::lower($email).'|'.$ip);
    }
}
