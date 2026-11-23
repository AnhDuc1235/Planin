<?php

namespace Database\Factories;

use App\Models\Checklist;
use App\Models\Task;
use Database\Factories\Concerns\UsesVietnameseFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Checklist>
 */
class ChecklistFactory extends Factory
{
    use UsesVietnameseFaker;

    public function definition(): array
    {
        return [
            'task_id' => Task::factory(),
            'title' => $this->faker->randomElement(['Việc cần làm', 'Danh sách kiểm tra', 'Chuẩn bị trước khi họp', 'Các bước thực hiện']),
            'position' => 0,
        ];
    }
}
