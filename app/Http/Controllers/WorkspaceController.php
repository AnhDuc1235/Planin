<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkspaceController extends Controller
{
    /**
     * Hiển thị trang quản lý Workspace & Board
     * Lấy dữ liệu thuần từ Database MySQL, truyền thẳng vào View
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Lấy danh sách Không gian làm việc kèm các Bảng của người dùng
        $workspaces = Workspace::where('user_id', $userId)
            ->with(['boards' => function ($query) {
                $query->latest();
            }])
            ->latest()
            ->get();

        $activeWorkspaceId = $request->query('workspace_id');
        $currentWorkspace = ($activeWorkspaceId ? $workspaces->firstWhere('id', (int) $activeWorkspaceId) : null)
            ?? $workspaces->first();

        return view('board', [
            'workspaces' => $workspaces,
            'currentWorkspace' => $currentWorkspace,
            'activeWorkspaceId' => $activeWorkspaceId,
        ]);
    }

    /**
     * Tạo Không gian làm việc mới (Thuần Session Form POST - KHÔNG DÙNG API)
     */
    public function storeWorkspace(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'type' => 'nullable|string|max:50',
        ]);

        $workspace = Workspace::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'color' => '#AA6ADA',
            'visibility' => 'public',
        ]);

        return redirect()->route('board', ['workspace_id' => $workspace->id])
            ->with('success', 'Tạo Không gian làm việc thành công!');
    }

    /**
     * Tạo Bảng mới trong Workspace (Thuần Session Form POST - KHÔNG DÙNG API)
     */
    public function storeBoard(Request $request)
    {
        $validated = $request->validate([
            'workspace_id' => 'required|exists:workspaces,id',
            'name' => 'required|string|max:150',
            'background' => 'nullable|string|max:255',
            'visibility' => 'nullable|in:private,workspace,public',
        ]);

        // Đảm bảo người dùng sở hữu workspace này
        $workspace = Workspace::where('id', $validated['workspace_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        Board::create([
            'workspace_id' => $workspace->id,
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'background' => $validated['background'] ?? 'linear-gradient(135deg, #0079BF, #5067C5)',
            'visibility' => $validated['visibility'] ?? 'workspace',
        ]);

        return redirect()->route('board', ['workspace_id' => $workspace->id])
            ->with('success', 'Tạo bảng thành công!');
    }
}

