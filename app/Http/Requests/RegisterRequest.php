<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Xác thực quyền gửi request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Quy tắc kiểm tra dữ liệu đăng ký.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:190|unique:users,email',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Thông báo lỗi tiếng Việt dễ hiểu.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là chuỗi văn bản.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'email' => ':attribute phải là địa chỉ email hợp lệ.',
            'email.unique' => 'Địa chỉ email này đã được sử dụng.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        ];
    }

    /**
     * Tên hiển thị của các thuộc tính.
     */
    public function attributes(): array
    {
        return [
            'name' => 'Họ và tên',
            'email' => 'Địa chỉ Email',
            'password' => 'Mật khẩu',
        ];
    }
}

