<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Database\Factories\Concerns\UsesVietnameseFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    use UsesVietnameseFaker;

    public function definition(): array
    {
        return [
            'task_id' => Task::factory(),
            'user_id' => User::factory(),
            'content' => $this->faker->randomElement([
                'Mình đã bắt đầu làm phần này rồi nhé.',
                'Cần thêm thông tin từ khách hàng trước khi tiếp tục.',
                'Đã xong, nhờ mọi người kiểm tra giúp.',
                'Hạn chót hơi gấp, cần hỗ trợ thêm nhân sự.',
                'Đã cập nhật theo góp ý của anh/chị.',
            ]),
        ];
    }
}
