<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\AccountService;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Tài khoản: đăng ký (store) và hồ sơ cá nhân (edit, update, updatePassword).
 * Mọi thao tác hồ sơ chỉ tác động lên CHÍNH người đang đăng nhập ($request->user()),
 * không nhận id từ URL nên không cần Policy.
 */
class AccountController extends Controller
{
    public function __construct(
        private readonly AccountService $accounts,
        private readonly AuthService $auth,
    ) {
    }

    /** Form đăng ký (chỉ khách: route có middleware check.guest). */
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(StoreAccountRequest $request): RedirectResponse
    {
        $user = $this->accounts->create($request->validated());

        $this->auth->loginUser($user);

        return redirect()->intended(route('workspaces.index'))
            ->with('success', 'Đăng ký thành công. Chào mừng bạn đến với Planin!');
    }

    public function edit(Request $request): View
    {
        return view('account.edit', ['user' => $request->user()]);
    }

    public function update(UpdateAccountRequest $request): RedirectResponse
    {
        $this->accounts->updateProfile($request->user(), $request->validated());

        return redirect()->route('account.edit')->with('success', 'Đã cập nhật hồ sơ.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $this->accounts->changePassword($request->user(), $request->validated('password'));

        return redirect()->route('account.edit')->with('success', 'Đã đổi mật khẩu.');
    }
}
