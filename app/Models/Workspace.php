<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'color',
        'visibility',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'workspace_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function boards()
    {
        return $this->hasMany(Board::class)->latest();
    }

    public function taskLists()
    {
        return $this->hasMany(TaskList::class)->orderBy('position');
    }

    public function labels()
    {
        return $this->hasMany(Label::class);
    }
}

