<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskAssignedNotification extends Notification
{
    use Queueable;
    protected Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'task_assigned',
            'title' => 'Tugas Baru',
            'message' => auth()->user()->name . ' menambahkan Anda ke task:',
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'project_id' => $this->task->project->id,
            'project_name' => $this->task->project->name,
        ];
    }

    
    public function toArray($notifiable)
    {
        return [
            'title' => 'Task Baru',
            'message' => 'Anda ditugaskan ke task',
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'url' => route('tasks.show', $this->task->id),
        ];
    }

}
