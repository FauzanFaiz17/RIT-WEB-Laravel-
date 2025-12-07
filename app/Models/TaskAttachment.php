<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAttachment extends Model
{
        protected $fillable = [
        'task_id',
        'file_path',
        'type',
        'original_name',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
