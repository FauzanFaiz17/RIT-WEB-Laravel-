<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
        protected $fillable = [
        'project_id',
        'parent_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'progress',
        'is_done',
    ];

    // --- Relasi ke Project ---
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // --- Relasi ke Task induk (parent) ---
    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    // --- Relasi ke subtask ---
    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    // --- Relasi ke user (many to many) ---
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // --- Lampiran/files ---
    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class);
    }
}
