<?php

namespace App\Enums;

use App\Enums\Concerns\HasConfigLabels;

/**
 * Vai trò của thành viên TRONG một workspace (workspace_members.role).
 * Khác với users.role (quyền quản trị toàn hệ thống).
 *
 *   viewer < member < admin
 *
 * "Chủ sở hữu" (workspaces.user_id) không phải một role: đó là quyền riêng,
 * kiểm tra trong WorkspacePolicy.
 */
enum WorkspaceRole: string
{
    use HasConfigLabels;

    case Admin = 'admin';
    case Member = 'member';
    case Viewer = 'viewer';

    public static function configGroup(): string
    {
        return 'workspace_member_role';
    }

    /** Role mặc định khi mời thành viên mới. */
    public static function default(): self
    {
        return self::Member;
    }

    /** Cấp độ quyền để so sánh (số lớn = quyền cao hơn). */
    public function level(): int
    {
        return match ($this) {
            self::Viewer => 1,
            self::Member => 2,
            self::Admin => 3,
        };
    }

    public function atLeast(self $minimum): bool
    {
        return $this->level() >= $minimum->level();
    }

    /** viewer trở lên: xem bảng, cột, thẻ. */
    public function canView(): bool
    {
        return $this->atLeast(self::Viewer);
    }

    /** member trở lên: thao tác thẻ/cột (thêm, sửa, kéo thả, bình luận). */
    public function canEditCards(): bool
    {
        return $this->atLeast(self::Member);
    }

    /** admin: quản lý bảng và thành viên. */
    public function canManage(): bool
    {
        return $this->atLeast(self::Admin);
    }
}
