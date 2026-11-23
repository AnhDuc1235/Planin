<?php

/*
|--------------------------------------------------------------------------
| Cấu hình riêng của Planin
|--------------------------------------------------------------------------
| Giá trị lưu trong database luôn là KEY tiếng Anh (vd: 'admin', 'high'),
| còn nhãn hiển thị tiếng Việt nằm ở đây. Khi thêm/sửa giá trị enum trong
| migration, nhớ cập nhật mục tương ứng ở file này.
|
| Cách dùng:
|   config('planin.enums.task_priority.high')            // "Cao"
|   \App\Support\PlaninEnum::label('task_priority', 'high')
|   $task->priority_label                                // accessor trong model
*/

return [

    'enums' => [

        // users.role (quyền toàn hệ thống)
        'user_role' => [
            'admin' => 'Quản trị viên',
            'member' => 'Thành viên',
        ],

        // workspaces.visibility
        'workspace_visibility' => [
            'private' => 'Riêng tư',
            'public' => 'Công khai',
        ],

        // workspace_members.role (quyền trong từng workspace)
        'workspace_member_role' => [
            'admin' => 'Quản trị viên',
            'member' => 'Thành viên',
            'viewer' => 'Người xem',
        ],

        // boards.visibility
        'board_visibility' => [
            'private' => 'Riêng tư',
            'workspace' => 'Không gian làm việc',
            'public' => 'Công khai',
        ],

        // tasks.priority
        'task_priority' => [
            'low' => 'Thấp',
            'medium' => 'Trung bình',
            'high' => 'Cao',
            'urgent' => 'Khẩn cấp',
        ],
    ],

    // activity_logs.action (cột string, không phải enum DB nhưng cũng cần nhãn tiếng Việt)
    'activity_actions' => [
        'created' => 'Đã tạo',
        'updated' => 'Đã cập nhật',
        'moved' => 'Đã di chuyển',
        'completed' => 'Đã hoàn thành',
        'commented' => 'Đã bình luận',
        'member_added' => 'Đã thêm thành viên',
        'archived' => 'Đã lưu trữ',
    ],

    // Phông nền bảng (boards.background): giá trị CSS => tên hiển thị.
    // Khớp với danh sách đang dùng ở modal tạo bảng.
    'board_backgrounds' => [
        'linear-gradient(135deg, #0079BF, #5067C5)' => 'Xanh dương',
        'linear-gradient(135deg, #1d1135, #4b1d7d, #aa6ada)' => 'Tím đêm',
        'linear-gradient(135deg, #d68541, #7a349c)' => 'Hoàng hôn',
        'linear-gradient(135deg, #0f2027, #203a43, #2c5364)' => 'Xanh đại dương',
        '#F0E5FC' => 'Tím nhạt',
        '#AA6ADA' => 'Tím Planin',
        '#7F42BC' => 'Tím đậm',
        '#0079BF' => 'Xanh Planin',
    ],

    // Màu nhãn (labels.color) và màu workspace (workspaces.color)
    'label_colors' => [
        '#AA6ADA' => 'Tím',
        '#61BD4F' => 'Xanh lá',
        '#F2D600' => 'Vàng',
        '#FF9F1A' => 'Cam',
        '#EB5A46' => 'Đỏ',
        '#00C2E0' => 'Xanh ngọc',
        '#0079BF' => 'Xanh dương',
        '#FF78CB' => 'Hồng',
    ],

    'workspace_colors' => [
        '#AA6ADA',
        '#7F42BC',
        '#0079BF',
        '#61BD4F',
        '#FF9F1A',
        '#EB5A46',
    ],

    // Mật khẩu của các tài khoản mẫu do seeder tạo
    'seed_password' => 'password123',
];
