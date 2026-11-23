<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Workspace;
use Database\Factories\Concerns\UsesVietnameseFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Workspace>
 */
class WorkspaceFactory extends Factory
{
    use UsesVietnameseFaker;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->randomElement([
                'Kế hoạch dự án chính',
                'Marketing & Truyền thông',
                'Phát triển sản phẩm',
                'Chăm sóc khách hàng',
                'Nhân sự & Tuyển dụng',
                'Kế toán - Tài chính',
                'Nghiên cứu thị trường',
            ]) . ' ' . $this->faker->numberBetween(1, 999),
            'description' => $this->faker->randomElement([
                'Không gian làm việc chung của cả nhóm.',
                'Theo dõi tiến độ và phân công công việc hằng tuần.',
                'Nơi trao đổi, lên kế hoạch và quản lý công việc.',
            ]),
            'color' => $this->faker->randomElement(config('planin.workspace_colors')),
            'visibility' => $this->faker->randomElement(array_keys(config('planin.enums.workspace_visibility'))),
        ];
    }

    public function private(): static
    {
        return $this->state(fn (array $attributes) => ['visibility' => 'private']);
    }

    public function public(): static
    {
        return $this->state(fn (array $attributes) => ['visibility' => 'public']);
    }
}
