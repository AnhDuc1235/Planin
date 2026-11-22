<?php

namespace App\Enums\Concerns;

use App\Support\PlaninEnum;

/**
 * Trait dùng chung cho các backed enum của Planin.
 *
 * Nhãn tiếng Việt KHÔNG viết cứng trong enum mà đọc từ config/planin.php
 * (nhóm do configGroup() trả về) để chỉ có một nguồn dữ liệu duy nhất.
 */
trait HasConfigLabels
{
    /** Tên nhóm trong config('planin.enums.*'). */
    abstract public static function configGroup(): string;

    /**
     * Danh sách giá trị hợp lệ (dùng cho Rule::in, factory...).
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }

    /**
     * [giá trị => nhãn tiếng Việt] (dùng để đổ vào <select>, dropdown).
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return PlaninEnum::all(static::configGroup());
    }

    /** Nhãn tiếng Việt của case hiện tại. */
    public function label(): string
    {
        return PlaninEnum::label(static::configGroup(), $this->value) ?? $this->value;
    }

    /** Một case ngẫu nhiên (dùng cho factory/seeder). */
    public static function random(): static
    {
        $cases = static::cases();

        return $cases[array_rand($cases)];
    }
}
