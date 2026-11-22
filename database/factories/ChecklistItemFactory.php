<?php

namespace Database\Factories;

use App\Models\Checklist;
use App\Models\ChecklistItem;
use Database\Factories\Concerns\UsesVietnameseFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChecklistItem>
 */
class ChecklistItemFactory extends Factory
{
    use UsesVietnameseFaker;

    public function definition(): array
    {
        return [
            'checklist_id' => Checklist::factory(),
            'content' => $this->faker->randomElement([
                'Gửi email xác nhận',
                'Kiểm tra lại số liệu',
                'Chụp ảnh màn hình kết quả',
                'Xin ý kiến quản lý',
                'Cập nhật tài liệu',
                'Thông báo cho cả nhóm',
            ]),
            'is_completed' => false,
            'position' => 0,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => ['is_completed' => true]);
    }
}
