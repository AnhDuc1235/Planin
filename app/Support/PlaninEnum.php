<?php

namespace App\Support;

/**
 * Tiện ích đọc các enum khai báo trong config/planin.php.
 * DB lưu key tiếng Anh, giao diện hiển thị nhãn tiếng Việt.
 */
class PlaninEnum
{
    /**
     * Toàn bộ [key => nhãn] của một nhóm enum.
     *
     * @return array<string, string>
     */
    public static function all(string $group): array
    {
        return config('planin.enums.' . $group, []);
    }

    /**
     * Danh sách key hợp lệ (dùng cho Rule::in, factory...).
     *
     * @return array<int, string>
     */
    public static function values(string $group): array
    {
        return array_keys(static::all($group));
    }

    /**
     * Nhãn tiếng Việt của một giá trị; không có thì trả lại chính giá trị đó.
     */
    public static function label(string $group, ?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return static::all($group)[$value] ?? $value;
    }

    /**
     * Một key ngẫu nhiên của nhóm enum (dùng cho factory).
     */
    public static function random(string $group): string
    {
        $values = static::values($group);

        return $values[array_rand($values)];
    }

    /**
     * Nhãn của hành động trong nhật ký hoạt động.
     */
    public static function actionLabel(?string $action): ?string
    {
        if ($action === null) {
            return null;
        }

        return config('planin.activity_actions.' . $action, $action);
    }
}
