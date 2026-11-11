<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_list_id',
        'user_id',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'position',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_assignees')->withTimestamps();
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'task_labels')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}

