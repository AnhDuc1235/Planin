<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Board;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use App\Models\Comment;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class PlaninSeeder extends Seeder
{
    /** Tên 4 cột mặc định của mỗi bảng (cột cuối = đã hoàn thành). */
    private const LIST_NAMES = ['Cần làm', 'Đang thực hiện', 'Chờ duyệt', 'Hoàn thành'];

    /** Nhãn mẫu cho mỗi bảng. */
    private const LABELS = [
        ['Thiết kế', '#AA6ADA'],
        ['Lập trình', '#61BD4F'],
        ['Kiểm thử', '#FF9F1A'],
        ['Tài liệu', '#0079BF'],
        ['Khẩn cấp', '#EB5A46'],
    ];

    private const BOARD_NAMES = [
        'Sprint tuần này',
        'Lộ trình sản phẩm',
        'Chiến dịch quý 4',
        'Website công ty',
        'Tuyển dụng 2026',
    ];

    private const TASK_TITLES = [
        'Khảo sát nhu cầu người dùng',
        'Thiết kế giao diện trang chủ',
        'Viết tài liệu hướng dẫn sử dụng',
        'Kiểm thử chức năng đăng nhập',
        'Chuẩn bị nội dung buổi họp tuần',
        'Tối ưu tốc độ tải trang',
        'Liên hệ nhà cung cấp',
        'Cập nhật báo cáo tiến độ',
        'Sửa lỗi hiển thị trên điện thoại',
        'Lên kế hoạch truyền thông',
        'Rà soát phản hồi của khách hàng',
        'Triển khai bản demo cho đối tác',
        'Áp dụng bảng màu thương hiệu',
        'Thiết lập môi trường thử nghiệm',
        'Đánh giá hiệu quả chiến dịch',
    ];

    private const CHECKLIST_ITEMS = [
        'Gửi email xác nhận',
        'Kiểm tra lại số liệu',
        'Xin ý kiến quản lý',
        'Cập nhật tài liệu',
        'Thông báo cho cả nhóm',
        'Chụp ảnh màn hình kết quả',
    ];

    /** Dùng để rải thời gian của nhật ký hoạt động. */
    private int $logMinutes = 0;

    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->firstOrFail();
        $member = User::where('email', 'member@example.com')->firstOrFail();
        $others = User::where('role', 'member')
            ->where('email', '!=', 'member@example.com')
            ->orderBy('id')
            ->get();

        $specs = [
            [
                'name' => 'Kế hoạch dự án chính',
                'description' => 'Không gian làm việc quản lý dự án Planin.',
                'color' => '#AA6ADA',
                'visibility' => 'private',
                'owner' => $admin,
            ],
            [
                'name' => 'Marketing & Truyền thông',
                'description' => 'Lên kế hoạch và theo dõi các chiến dịch truyền thông.',
                'color' => '#0079BF',
                'visibility' => 'public',
                'owner' => $member,
            ],
            [
                'name' => 'Phát triển sản phẩm',
                'description' => 'Theo dõi tiến độ phát triển tính năng mới.',
                'color' => '#61BD4F',
                'visibility' => 'private',
                'owner' => $others->first(),
            ],
        ];

        foreach ($specs as $spec) {
            $this->seedWorkspace($spec, $admin, $member);
        }
    }

    private function seedWorkspace(array $spec, User $admin, User $member): void
    {
        /** @var User $owner */
        $owner = $spec['owner'];

        $workspace = Workspace::factory()->create([
            'user_id' => $owner->id,
            'name' => $spec['name'],
            'description' => $spec['description'],
            'color' => $spec['color'],
            'visibility' => $spec['visibility'],
        ]);

        $members = $this->attachMembers($workspace, $owner, $admin, $member);

        // Chỉ thành viên có quyền thao tác (admin/member) mới tạo thẻ, bình luận, được giao việc
        $workers = $members->filter(fn (array $m) => $m['role'] !== 'viewer')
            ->pluck('user')->values();

        $boardCount = random_int(2, 3);
        $boardNames = collect(self::BOARD_NAMES)->shuffle()->take($boardCount)->values();

        foreach ($boardNames as $index => $boardName) {
            $board = Board::factory()->create([
                'workspace_id' => $workspace->id,
                'user_id' => $owner->id,
                'name' => $boardName,
            ]);

            $this->log($workspace, $owner, 'created', "đã tạo bảng \"{$board->name}\"", ['board_id' => $board->id]);

            $this->seedBoard($workspace, $board, $workers, $index === 0);
        }
    }

    /**
     * Thêm chủ sở hữu (role admin) và các thành viên/người xem vào workspace.
     *
     * @return Collection<int, array{user: User, role: string}>
     */
    private function attachMembers(Workspace $workspace, User $owner, User $admin, User $member): Collection
    {
        // Ưu tiên admin@ và member@ có mặt trong mọi workspace để dễ đăng nhập thử
        $required = collect([$admin, $member])->reject(fn (User $u) => $u->id === $owner->id);

        $extra = User::where('role', 'member')
            ->whereNotIn('id', $required->pluck('id')->push($owner->id))
            ->inRandomOrder()
            ->limit(5 - $required->count())
            ->get();

        $roles = ['member', 'member', 'member', 'viewer', 'viewer'];

        $joined = collect([['user' => $owner, 'role' => 'admin']]);
        foreach ($required->concat($extra)->values() as $i => $user) {
            $joined->push(['user' => $user, 'role' => $roles[$i] ?? 'member']);
        }

        foreach ($joined as $m) {
            $workspace->members()->attach($m['user']->id, ['role' => $m['role']]);
        }

        foreach ($joined->skip(1) as $m) {
            $this->log($workspace, $owner, 'member_added', "đã thêm {$m['user']->name} vào không gian làm việc", ['member_id' => $m['user']->id, 'role' => $m['role']]);
        }

        return $joined;
    }

    private function seedBoard(Workspace $workspace, Board $board, Collection $workers, bool $fourLists): void
    {
        $labels = collect(self::LABELS)->map(fn (array $l) => Label::factory()->create([
            'board_id' => $board->id,
            'name' => $l[0],
            'color' => $l[1],
        ]));

        $listNames = $fourLists
            ? self::LIST_NAMES
            : array_values(array_filter(self::LIST_NAMES, fn ($n) => $n !== 'Chờ duyệt'));

        $lastIndex = count($listNames) - 1;
        $titles = collect(self::TASK_TITLES);

        foreach ($listNames as $position => $listName) {
            $list = TaskList::factory()->create([
                'board_id' => $board->id,
                'name' => $listName,
                'position' => $position,
            ]);

            $isDone = $position === $lastIndex;

            $taskCount = random_int(3, 8);

            for ($t = 0; $t < $taskCount; $t++) {
                $creator = $workers->random();

                $task = Task::factory()->create([
                    'task_list_id' => $list->id,
                    'user_id' => $creator->id,
                    'title' => $titles->random(),
                    'position' => $t,
                    'completed_at' => $isDone ? now()->subDays(random_int(0, 7)) : null,
                ]);

                // Nhãn, người được giao (chỉ thành viên của workspace)
                $task->labels()->attach($labels->random(random_int(0, 2))->pluck('id')->all());
                $task->assignees()->attach($workers->random(min(random_int(0, 2), $workers->count()))->pluck('id')->all());

                // Bình luận
                $commentCount = random_int(0, 3);
                for ($c = 0; $c < $commentCount; $c++) {
                    Comment::factory()->create([
                        'task_id' => $task->id,
                        'user_id' => $workers->random()->id,
                    ]);
                }

                // Checklist (khoảng 40% thẻ)
                if (random_int(1, 100) <= 40) {
                    $this->seedChecklist($task, $isDone);
                }

                // Nhật ký hoạt động mẫu
                if ($t < 2) {
                    $this->log($workspace, $creator, 'created', "đã tạo thẻ \"{$task->title}\"", [], $board, $list, $task);
                }
                if ($isDone && $t < 2) {
                    $this->log($workspace, $creator, 'completed', "đã hoàn thành thẻ \"{$task->title}\"", [], $board, $list, $task);
                }
                if ($position > 0 && $t === 0) {
                    $this->log($workspace, $creator, 'moved', "đã chuyển thẻ \"{$task->title}\" sang cột \"{$list->name}\"", ['to_list' => $list->name], $board, $list, $task);
                }
            }
        }
    }

    private function seedChecklist(Task $task, bool $allDone): void
    {
        $checklist = Checklist::factory()->create([
            'task_id' => $task->id,
            'position' => 0,
        ]);

        $items = collect(self::CHECKLIST_ITEMS)->shuffle()->take(random_int(2, 5))->values();

        foreach ($items as $i => $content) {
            ChecklistItem::factory()->create([
                'checklist_id' => $checklist->id,
                'content' => $content,
                'position' => $i,
                'is_completed' => $allDone || random_int(0, 1) === 1,
            ]);
        }
    }

    private function log(
        Workspace $workspace,
        User $user,
        string $action,
        string $description,
        array $properties = [],
        ?Board $board = null,
        ?TaskList $list = null,
        ?Task $task = null,
    ): void {
        $time = now()->subMinutes(++$this->logMinutes);

        ActivityLog::factory()->create([
            'workspace_id' => $workspace->id,
            'board_id' => $board?->id ?? ($properties['board_id'] ?? null),
            'task_list_id' => $list?->id,
            'task_id' => $task?->id,
            'user_id' => $user->id,
            'action' => $action,
            'description' => $description,
            'properties' => $properties ?: null,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }
}
