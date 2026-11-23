<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Label;
use Database\Factories\Concerns\UsesVietnameseFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Label>
 */
class LabelFactory extends Factory
{
    use UsesVietnameseFaker;

    public function definition(): array
    {
        return [
            'board_id' => Board::factory(),
            'name' => $this->faker->randomElement(['Thiết kế', 'Lập trình', 'Kiểm thử', 'Tài liệu', 'Khẩn cấp', 'Họp']),
            'color' => $this->faker->randomElement(array_keys(config('planin.label_colors'))),
        ];
    }
}
