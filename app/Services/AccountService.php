<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

/**
 * Nghiệp vụ TÀI KHOẢN: tạo tài khoản, cập nhật hồ sơ (tên, avatar), đổi mật khẩu.
 *
 * Quy ước role: users.role chỉ dành cho quản trị toàn site; tài khoản mới luôn
 * là 'member'. Quyền với dữ liệu (workspace/board/thẻ) dựa vào workspace_members.role.
 */
class AccountService
{
    public const AVATAR_DISK = 'public';
    public const AVATAR_DIR = 'avatars';

    /**
     * @param  array{name: string, email: string, password: string}  $data  (đã validate)
     */
    public function create(array $data): User
    {
        // Không nhận role từ input; mật khẩu được băm bởi cast 'hashed' của User.
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'member',
        ]);
    }

    /**
     * @param  array{name: string, avatar?: UploadedFile|null, remove_avatar?: bool|string|null}  $data  (đã validate)
     */
    public function updateProfile(User $user, array $data): User
    {
        $oldAvatar = $user->avatar;
        $newAvatar = $data['avatar'] ?? null;
        $remove = filter_var($data['remove_avatar'] ?? false, FILTER_VALIDATE_BOOLEAN);

        $user->name = $data['name'];

        if ($newAvatar instanceof UploadedFile) {
            // Tên tệp ngẫu nhiên do Laravel sinh, không dùng tên người dùng gửi lên.
            $user->avatar = $newAvatar->store(self::AVATAR_DIR, self::AVATAR_DISK);
        } elseif ($remove) {
            $user->avatar = null;
        }

        $user->save();

        // Chỉ xóa file cũ sau khi lưu DB thành công.
        if ($oldAvatar && $oldAvatar !== $user->avatar) {
            Storage::disk(self::AVATAR_DISK)->delete($oldAvatar);
        }

        return $user;
    }

    /** Đổi mật khẩu (Request đã kiểm tra mật khẩu hiện tại). */
    public function changePassword(User $user, string $newPassword): void
    {
        $user->password = $newPassword; // cast 'hashed' tự băm
        $user->save();

        Session::regenerate();
    }
}
