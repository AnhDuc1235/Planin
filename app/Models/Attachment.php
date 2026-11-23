<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attachments';
    protected $fillable = [
        'task_id',
        'user_id',
        'file_name',
        'file_path',
        'file_size', // đơn vị KB
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /** Người tải tệp lên. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
