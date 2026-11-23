<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Workspace;
use Database\Factories\Concerns\UsesVietnameseFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Board>
 */
class BoardFactory extends Factory
{
    use UsesVietnameseFaker;

    public function definition(): array
    {
        return [
            'workspace_id' => Workspace::factory(),
            // Người tạo bảng mặc định là chủ workspace
            'user_id' => fn (array $attributes) => Workspace::query()->find($attributes['workspace_id'])?->user_id,
            'name' => $this->faker->randomElement([
                'Sprint tuần này',
                'Chiến dịch quý 4',
                'Lộ trình sản phẩm',
                'Tuyển dụng 2026',
                'Website công ty',
                'Ra mắt ứng dụng di động',
            ]),
            'background' => $this->faker->randomElement(array_keys(config('planin.board_backgrounds'))),
            'visibility' => $this->faker->randomElement(array_keys(config('planin.enums.board_visibility'))),
            'archived_at' => null,
        ];
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => ['archived_at' => now()]);
    }

    public function private(): static
    {
        return $this->state(fn (array $attributes) => ['visibility' => 'private']);
    }
}
