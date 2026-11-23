<?php

namespace Database\Factories;

use App\Models\ActivityLog;
use App\Models\Task;
use App\Models\User;
use App\Models\Workspace;
use Database\Factories\Concerns\UsesVietnameseFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    use UsesVietnameseFaker;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'workspace_id' => Workspace::factory(),
            'board_id' => null,
            'task_list_id' => null,
            'task_id' => null,
            'user_id' => User::factory(),
            'action' => $this->faker->randomElement(array_keys(config('planin.activity_actions'))),
            'description' => $this->faker->randomElement([
                'đã cập nhật thông tin thẻ',
                'đã thay đổi hạn chót',
                'đã thêm một bình luận',
            ]),
            'properties' => null,
        ];
    }

    /** Gắn log vào một thẻ (tự điền cột, bảng, workspace tương ứng). */
    public function forTask(Task $task): static
    {
        $task->loadMissing('taskList.board');

        return $this->state(fn (array $attributes) => [
            'workspace_id' => $task->taskList->board->workspace_id,
            'board_id' => $task->taskList->board_id,
            'task_list_id' => $task->task_list_id,
            'task_id' => $task->id,
        ]);
    }
}
