<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use App\Support\PlaninEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
    protected function roleLabel(): Attribute
    {
        return Attribute::get(fn () => PlaninEnum::label('user_role', $this->role));
    }

    public function ownedWorkspaces(): HasMany
    {
        return $this->hasMany(Workspace::class, 'user_id');
    }

    public function workspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class, 'workspace_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function assignedTasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_assignees')->withTimestamps();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function starredBoards(): BelongsToMany
    {
        return $this->belongsToMany(Board::class, 'board_stars')->withTimestamps();
    }
}
