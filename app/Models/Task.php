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
        'status'
    ];

    /**
     * Casts
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'progress' => 'integer',
    ];
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }
 
    
    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }
   
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user')->withTimestamps();
    }
}
