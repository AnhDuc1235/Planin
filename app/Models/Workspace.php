<?php

namespace App\Models;

use App\Support\PlaninEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Workspace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'color',
        'visibility',
    ];

    protected function visibilityLabel(): Attribute
    {
        return Attribute::get(fn () => PlaninEnum::label('workspace_visibility', $this->visibility));
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'workspace_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    /** Các bảng đang hoạt động (chưa lưu trữ), mới nhất trước. */
    public function boards(): HasMany
    {
        return $this->hasMany(Board::class)->whereNull('archived_at')->latest();
    }

    public function archivedBoards(): HasMany
    {
        return $this->hasMany(Board::class)->whereNotNull('archived_at')->latest('archived_at');
    }

    /** Nhãn thuộc các bảng của workspace (nhãn lưu theo bảng). */
    public function labels(): HasManyThrough
    {
        return $this->hasManyThrough(Label::class, Board::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }
}
