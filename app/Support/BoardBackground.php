<?php

namespace App\Support;

use Closure;

/**
 * Phông nền của bảng (boards.background).
 *
 * Danh sách preset nằm ở config('planin.board_backgrounds')
 * ([giá trị CSS => tên hiển thị]). Ngoài preset, chỉ chấp nhận mã màu hex
 * (#RGB / #RRGGBB) để chặn người dùng chèn CSS tùy ý vào thuộc tính style.
 */
final class BoardBackground
{
    public const COLOR_PATTERN = '/^#(?:[0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/';

    /** @return array<string, string> [giá trị CSS => tên hiển thị] */
    public static function presets(): array
    {
        return config('planin.board_backgrounds', []);
    }

    /** @return array<int, string> */
    public static function values(): array
    {
        return array_keys(static::presets());
    }

    /** Phông nền mặc định = preset đầu tiên. */
    public static function default(): string
    {
        return static::values()[0] ?? '#0079BF';
    }

    public static function isPreset(?string $value): bool
    {
        return $value !== null && in_array($value, static::values(), true);
    }

    public static function isColor(?string $value): bool
    {
        return $value !== null && preg_match(static::COLOR_PATTERN, $value) === 1;
    }

    public static function isValid(?string $value): bool
    {
        return static::isPreset($value) || static::isColor($value);
    }

    /**
     * Giá trị an toàn để in vào style="background: ...".
     * Giá trị lạ/rỗng được thay bằng phông nền mặc định.
     */
    public static function css(?string $value): string
    {
        return static::isValid($value) ? $value : static::default();
    }

    /**
     * Rule dùng trong FormRequest: 'background' => ['nullable', BoardBackground::rule()].
     */
    public static function rule(): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail): void {
            if (! is_string($value) || ! static::isValid($value)) {
                $fail('Phông nền của bảng không hợp lệ.');
            }
        };
    }
}
