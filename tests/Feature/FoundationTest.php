<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Attachment;
use App\Models\Board;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use App\Models\Comment;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;
use App\Models\Workspace;
use App\Support\PlaninEnum;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_factories_tao_du_chuoi_quan_he(): void
    {
        $task = Task::factory()->create();

        $task->load('taskList.board.workspace.owner');

        $this->assertNotNull($task->taskList);
        $this->assertNotNull($task->taskList->board);
        $this->assertNotNull($task->taskList->board->workspace);
        $this->assertNotNull($task->taskList->board->workspace->owner);
    }

    public function test_quan_he_hai_chieu(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $workspace = Workspace::factory()->create(['user_id' => $owner->id]);
        $workspace->members()->attach([
            $owner->id => ['role' => 'admin'],
            $other->id => ['role' => 'viewer'],
        ]);

        $board = Board::factory()->create(['workspace_id' => $workspace->id, 'user_id' => $owner->id]);
        $list = TaskList::factory()->create(['board_id' => $board->id]);
        $task = Task::factory()->create(['task_list_id' => $list->id, 'user_id' => $owner->id]);
        $label = Label::factory()->create(['board_id' => $board->id]);
        $comment = Comment::factory()->create(['task_id' => $task->id, 'user_id' => $other->id]);
        $attachment = Attachment::factory()->create(['task_id' => $task->id, 'user_id' => $owner->id]);
        $checklist = Checklist::factory()->create(['task_id' => $task->id]);
        $item = ChecklistItem::factory()->completed()->create(['checklist_id' => $checklist->id]);
        $log = ActivityLog::factory()->forTask($task)->create(['user_id' => $owner->id]);

        $task->labels()->attach($label);
        $task->assignees()->attach($other);
        $board->stars()->attach($owner);

        // Chiều xuôi
        $this->assertTrue($workspace->members->contains($other));
        $this->assertSame('viewer', $workspace->members->firstWhere('id', $other->id)->pivot->role);
        $this->assertTrue($workspace->boards->contains($board));
        $this->assertTrue($workspace->labels->contains($label));
        $this->assertTrue($board->taskLists->contains($list));
        $this->assertTrue($board->labels->contains($label));
        $this->assertTrue($list->tasks->contains($task));
        $this->assertTrue($task->labels->contains($label));
        $this->assertTrue($task->assignees->contains($other));
        $this->assertTrue($task->comments->contains($comment));
        $this->assertTrue($task->attachments->contains($attachment));
        $this->assertTrue($task->checklists->first()->items->contains($item));
        $this->assertTrue($task->activityLogs->contains($log));
        $this->assertTrue($board->activityLogs->contains($log));

        // Chiều ngược
        $this->assertTrue($owner->ownedWorkspaces->contains($workspace));
        $this->assertTrue($other->workspaces->contains($workspace));
        $this->assertTrue($other->assignedTasks->contains($task));
        $this->assertTrue($other->comments->contains($comment));
        $this->assertTrue($owner->starredBoards->contains($board));
        $this->assertTrue($label->tasks->contains($task));
        $this->assertSame($board->id, $label->board->id);
        $this->assertSame($task->id, $comment->task->id);
        $this->assertSame($other->id, $comment->user->id);
        $this->assertSame($list->id, $task->taskList->id);
        $this->assertSame($checklist->id, $item->checklist->id);
    }

    public function test_task_scope_va_state(): void
    {
        $list = TaskList::factory()->create();

        Task::factory()->create(['task_list_id' => $list->id]);
        Task::factory()->completed()->create(['task_list_id' => $list->id]);
        Task::factory()->archived()->create(['task_list_id' => $list->id]);

        $this->assertSame(1, Task::completed()->count());
        $this->assertSame(1, Task::archived()->count());
        $this->assertSame(2, Task::notArchived()->count());
        $this->assertTrue(Task::completed()->first()->isCompleted());
    }

    public function test_workspace_private_state_va_board_luu_tru(): void
    {
        $workspace = Workspace::factory()->private()->create();
        $active = Board::factory()->create(['workspace_id' => $workspace->id]);
        $archived = Board::factory()->archived()->create(['workspace_id' => $workspace->id]);

        $this->assertSame('private', $workspace->visibility);
        $this->assertTrue($workspace->boards->contains($active));
        $this->assertFalse($workspace->boards->contains($archived));
        $this->assertTrue($workspace->archivedBoards->contains($archived));
    }

    public function test_enum_hien_thi_tieng_viet(): void
    {
        $this->assertSame('Khẩn cấp', PlaninEnum::label('task_priority', 'urgent'));
        $this->assertSame('Người xem', PlaninEnum::label('workspace_member_role', 'viewer'));
        $this->assertSame('Không gian làm việc', PlaninEnum::label('board_visibility', 'workspace'));
        $this->assertSame('Riêng tư', PlaninEnum::label('workspace_visibility', 'private'));
        $this->assertSame('Quản trị viên', PlaninEnum::label('user_role', 'admin'));

        $task = Task::factory()->create(['priority' => 'high']);
        $this->assertSame('Cao', $task->priority_label);
    }

    public function test_seeder_tao_du_lieu_mau_day_du(): void
    {
        $this->seed(DatabaseSeeder::class);

        // 1 admin + 10 user thường
        $this->assertSame(1, User::where('role', 'admin')->count());
        $this->assertSame(10, User::where('role', 'member')->count());
        $this->assertNotNull(User::where('email', 'admin@example.com')->first());

        $this->assertGreaterThan(0, Workspace::count());
        $this->assertGreaterThan(0, Board::count());
        $this->assertGreaterThan(0, TaskList::count());
        $this->assertGreaterThan(0, Task::count());
        $this->assertGreaterThan(0, ActivityLog::count());

        // Chủ mỗi workspace đều nằm trong workspace_members với role admin
        foreach (Workspace::with('members')->get() as $workspace) {
            $owner = $workspace->members->firstWhere('id', $workspace->user_id);
            $this->assertNotNull($owner);
            $this->assertSame('admin', $owner->pivot->role);
        }

        $task = Task::with('taskList.board.workspace')->first();
        $this->assertNotNull($task->taskList->board->workspace);

        // Người được giao thẻ phải là thành viên của workspace chứa thẻ
        foreach (Task::with('assignees', 'taskList.board.workspace.members')->get() as $task) {
            $memberIds = $task->taskList->board->workspace->members->pluck('id');
            foreach ($task->assignees as $assignee) {
                $this->assertTrue($memberIds->contains($assignee->id));
            }
        }
    }
}
