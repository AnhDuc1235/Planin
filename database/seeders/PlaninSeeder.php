<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workspace;
use App\Models\TaskList;
use App\Models\Task;
use App\Models\Label;
use Illuminate\Database\Seeder;

class PlaninSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (!$user) return;

        // 1. Tạo Workspace mẫu
        $workspace = Workspace::firstOrCreate(
            ['name' => 'Kế hoạch dự án chính'],
            [
                'user_id' => $user->id,
                'description' => 'Không gian làm việc quản lý dự án Planin.',
                'color' => '#AA6ADA',
                'visibility' => 'private',
            ]
        );

        // 2. Tạo các cột trạng thái (Lists)
        $todoList = TaskList::firstOrCreate(
            ['workspace_id' => $workspace->id, 'name' => 'Cần làm (To Do)'],
            ['position' => 0]
        );

        $inProgressList = TaskList::firstOrCreate(
            ['workspace_id' => $workspace->id, 'name' => 'Đang thực hiện (In Progress)'],
            ['position' => 1]
        );

        $doneList = TaskList::firstOrCreate(
            ['workspace_id' => $workspace->id, 'name' => 'Hoàn thành (Done)'],
            ['position' => 2]
        );

        // 3. Tạo nhãn màu
        $labelDesign = Label::firstOrCreate(
            ['workspace_id' => $workspace->id, 'name' => 'Thiết kế'],
            ['color' => '#AA6ADA']
        );

        $labelDev = Label::firstOrCreate(
            ['workspace_id' => $workspace->id, 'name' => 'Lập trình'],
            ['color' => '#61bd4f']
        );

        // 4. Tạo các task mẫu
        Task::firstOrCreate(
            ['title' => 'Khảo sát giao diện người dùng'],
            [
                'task_list_id' => $todoList->id,
                'user_id' => $user->id,
                'description' => 'Thu thập ý kiến đóng góp từ thành viên.',
                'priority' => 'medium',
                'status' => 'todo',
                'position' => 0,
            ]
        );

        Task::firstOrCreate(
            ['title' => 'Áp dụng bảng màu tím #AA6ADA'],
            [
                'task_list_id' => $inProgressList->id,
                'user_id' => $user->id,
                'description' => 'Chuẩn hóa màu thương hiệu vào hệ thống.',
                'priority' => 'high',
                'status' => 'in_progress',
                'position' => 0,
            ]
        );

        Task::firstOrCreate(
            ['title' => 'Khởi tạo cấu trúc Database & Migration'],
            [
                'task_list_id' => $doneList->id,
                'user_id' => $user->id,
                'description' => 'Hoàn thiện 11 bảng CSDL theo chuẩn Laravel.',
                'priority' => 'urgent',
                'status' => 'done',
                'position' => 0,
            ]
        );
    }
}

