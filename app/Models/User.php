<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * users.role CHỈ để phân quyền quản trị toàn site (admin / member).
     * KHÔNG dùng để quyết định quyền với workspace/board/thẻ: các quyền đó dựa
     * vào workspace_members.role (xem App\Enums\WorkspaceRole và các Policy).
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    /** URL ảnh đại diện (cần `php artisan storage:link`), null nếu chưa có. */
    protected function avatarUrl(): Attribute
    {
        return Attribute::get(
            fn () => $this->avatar ? asset('storage/'.$this->avatar) : null
        );
    }

    /** Chữ cái viết tắt hiển thị khi chưa có avatar, vd. "Nguyễn Văn Thành" -> "NT". */
    protected function initials(): Attribute
    {
        return Attribute::get(function () {
            $words = preg_split('/\s+/u', trim((string) $this->name), -1, PREG_SPLIT_NO_EMPTY);

            if (! $words) {
                return 'PL';
            }

            $initials = count($words) > 1
                ? mb_substr($words[0], 0, 1, 'UTF-8').mb_substr(end($words), 0, 1, 'UTF-8')
                : mb_substr($words[0], 0, 2, 'UTF-8');

            return mb_strtoupper($initials, 'UTF-8');
        });
    }
}
