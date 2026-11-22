<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Cập nhật hồ sơ: tên + ảnh đại diện (AccountController@update).
 * Email và role không cho sửa ở đây.
 */
class UpdateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        if (is_string($this->name)) {
            $this->merge(['name' => trim($this->name)]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            // Không cho svg (có thể chứa script) -> chỉ nhận ảnh raster.
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048', // KB
                'dimensions:max_width=4000,max_height=4000',
            ],
            'remove_avatar' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là chuỗi văn bản.',
            'name.max' => ':attribute không được vượt quá :max ký tự.',
            'avatar.image' => 'Ảnh đại diện phải là tệp hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện chỉ chấp nhận định dạng JPG, PNG hoặc WEBP.',
            'avatar.max' => 'Ảnh đại diện không được lớn hơn 2 MB.',
            'avatar.uploaded' => 'Tải ảnh đại diện thất bại (tệp có thể quá lớn).',
            'avatar.dimensions' => 'Ảnh đại diện không được vượt quá 4000 x 4000 điểm ảnh.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Họ và tên',
            'avatar' => 'Ảnh đại diện',
        ];
    }
}
