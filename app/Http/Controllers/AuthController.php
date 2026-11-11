<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Hiển thị trang đăng nhập.
     * Dùng session: nếu đã đăng nhập rồi -> chuyển thẳng về trang board.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/board');
        }

        return view('auth.login');
    }

    /**
     * Hiển thị trang đăng ký.
     * Dùng session: nếu đã đăng nhập rồi -> chuyển thẳng về trang board.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect('/board');
        }

        return view('auth.register');
    }

    /**
     * Xử lý đăng nhập bằng form submit truyền thống (Dùng Session, KHÔNG dùng API).
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        $remember = $request->boolean('remember');

        // Xác thực qua session thuần Laravel
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect('/board');
        }

        // Đăng nhập thất bại: trả lại form đăng nhập kèm thông báo lỗi qua session
        return back()->withErrors([
            'login_error' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    /**
     * Xử lý đăng ký bằng form submit truyền thống (Dùng Session, KHÔNG dùng API).
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:190|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'email.unique' => 'Địa chỉ email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        // Tạo tài khoản mới vào CSDL
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'member',
        ]);

        // Đăng nhập ngay lập tức qua session
        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/board');
    }

    /**
     * Xử lý đăng xuất (Dùng Session, KHÔNG dùng API).
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
