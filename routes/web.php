<?php

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

// 2. Auth: Đăng nhập & Đăng ký (Xử lý hoàn toàn bằng Session Laravel)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Quản lý Workspace & Board (Áp dụng Middleware check.login)
// Thuần Session & Form POST Laravel - KHÔNG DÙNG API
Route::middleware('check.login')->group(function () {
    Route::get('/board', [WorkspaceController::class, 'index'])->name('board');
    Route::post('/workspaces', [WorkspaceController::class, 'storeWorkspace'])->name('workspaces.store');
    Route::post('/boards', [WorkspaceController::class, 'storeBoard'])->name('boards.store');
});
