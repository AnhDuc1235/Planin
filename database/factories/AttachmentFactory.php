<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Task;
use App\Models\User;
use Database\Factories\Concerns\UsesVietnameseFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Attachment>
 */
class AttachmentFactory extends Factory
{
    use UsesVietnameseFaker;

    public function definition(): array
    {
        $fileName = $this->faker->randomElement([
            'bao-cao-tien-do.pdf',
            'thiet-ke-giao-dien.png',
            'bang-du-lieu.xlsx',
            'noi-dung-hop.docx',
        ]);

        return [
            'task_id' => Task::factory(),
            'user_id' => User::factory(),
            'file_name' => $fileName,
            'file_path' => 'attachments/demo/' . Str::random(20) . '-' . $fileName,
            'file_size' => $this->faker->numberBetween(10, 5000), // KB
        ];
    }
}
