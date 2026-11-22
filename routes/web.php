<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Dùng thuần Session - KHÔNG dùng API)
|--------------------------------------------------------------------------
*/

// 1. Trang chủ (Khách chưa đăng nhập vào xem trang chủ)
Route::get('/', function () {
    return view('home');
})->name('home');

// 2. Chỉ dành cho KHÁCH (đã đăng nhập thì middleware check.guest chuyển về /board)
Route::middleware('check.guest')->group(function () {
    // Đăng nhập (AuthController / AuthService)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Đăng ký tài khoản (AccountController / AccountService)
    Route::get('/register', [AccountController::class, 'create'])->name('register');
    Route::post('/register', [AccountController::class, 'store'])->name('register.post');

    // Quên / đặt lại mật khẩu. Tên route 'password.reset' là tên Laravel dùng để
    // dựng liên kết trong email, vì vậy KHÔNG đổi tên.
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->middleware('throttle:6,1')
        ->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// 3. Cần đăng nhập (middleware check.login; chưa đăng nhập -> /login, sau đó quay lại URL cũ)
Route::middleware('check.login')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Hồ sơ cá nhân: tên, avatar, đổi mật khẩu
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');

    // Quản lý Workspace & Board (sẽ tách lại ở bước 4 và 6)
    Route::get('/board', [WorkspaceController::class, 'index'])->name('workspaces.index');
    Route::post('/workspaces', [WorkspaceController::class, 'storeWorkspace'])->name('workspaces.store');
    Route::post('/boards', [WorkspaceController::class, 'storeBoard'])->name('boards.store');
});

// 4. Route thử hạ tầng - CHỈ môi trường local (kiểm tra layout/Vue/trang lỗi)
if (app()->environment('local')) {
    Route::middleware('check.login')->prefix('_dev')->group(function () {
        Route::view('/vue-test', 'dev.vue-test')->name('dev.vue-test');
        Route::get('/abort/{code}', fn (int $code) => abort($code))
            ->whereIn('code', [403, 404, 419, 429, 500, 503])
            ->name('dev.abort');
    });
}
