<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\TaskList;
use Database\Factories\Concerns\UsesVietnameseFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TaskList>
 */
class TaskListFactory extends Factory
{
    use UsesVietnameseFaker;

    public function definition(): array
    {
        return [
            'board_id' => Board::factory(),
            'name' => $this->faker->randomElement(['Cần làm', 'Đang thực hiện', 'Chờ duyệt', 'Hoàn thành']),
            'position' => 0,
            'archived_at' => null,
        ];
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => ['archived_at' => now()]);
    }
}
