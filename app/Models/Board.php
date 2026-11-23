<?php

namespace App\Models;

use App\Support\PlaninEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'boards';
    protected $fillable = [
        'workspace_id',
        'user_id',
        'name',
        'background',
        'visibility',
        'archived_at',
    ];

    protected function casts(): array
    {
        return [
            'archived_at' => 'datetime',
        ];
    }

    public function scopeNotArchived(Builder $query): Builder
    {
        return $query->whereNull('archived_at');
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->whereNotNull('archived_at');
    }

    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }

    protected function visibilityLabel(): Attribute
    {
        return Attribute::get(fn () => PlaninEnum::label('board_visibility', $this->visibility));
    }

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    /** Người tạo bảng. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function taskLists(): HasMany
    {
        return $this->hasMany(TaskList::class)->orderBy('position');
    }

    public function labels(): HasMany
    {
        return $this->hasMany(Label::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /** Những người đã gắn sao bảng này. */
    public function stars(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_stars')->withTimestamps();
    }
}
