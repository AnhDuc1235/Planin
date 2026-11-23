<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;
use Database\Factories\Concerns\UsesVietnameseFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    use UsesVietnameseFaker;

    public function definition(): array
    {
        $hasDue = $this->faker->boolean(60);

        return [
            'task_list_id' => TaskList::factory(),
            'user_id' => User::factory(),
            'title' => $this->faker->randomElement([
                'Khảo sát nhu cầu người dùng',
                'Thiết kế giao diện trang chủ',
                'Viết tài liệu hướng dẫn sử dụng',
                'Kiểm thử chức năng đăng nhập',
                'Chuẩn bị nội dung cho buổi họp tuần',
                'Tối ưu tốc độ tải trang',
                'Liên hệ nhà cung cấp',
                'Cập nhật báo cáo tiến độ',
                'Sửa lỗi hiển thị trên điện thoại',
                'Lên kế hoạch truyền thông',
                'Rà soát phản hồi của khách hàng',
                'Triển khai bản demo cho đối tác',
            ]),
            'description' => $this->faker->randomElement([
                'Thu thập ý kiến đóng góp từ các thành viên trong nhóm.',
                'Hoàn thiện theo yêu cầu đã thống nhất trong buổi họp.',
                'Cần xong trước khi chuyển sang giai đoạn tiếp theo.',
                'Ghi chú lại kết quả và gửi cho người phụ trách.',
                null,
            ]),
            'priority' => $this->faker->randomElement(array_keys(config('planin.enums.task_priority'))),
            'start_date' => null,
            'due_date' => $hasDue ? now()->addDays($this->faker->numberBetween(-5, 21))->setTime(17, 0) : null,
            'completed_at' => null,
            'cover' => null,
            'position' => 0,
            'archived_at' => null,
        ];
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => ['archived_at' => now()]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => ['completed_at' => now()]);
    }
}
