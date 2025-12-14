<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\TaskAttachment;
 
class TaskAttachmentSeeder extends Seeder
{
    public function run()
    {
        $task = Task::first();

        if ($task) {
            TaskAttachment::create([
                'task_id' => $task->id,
                'file_path' => 'tasks/'.$task->id.'/contoh_file.pdf',
                'type' => 'pdf',
                'original_name' => 'contoh_file.pdf'
            ]);

            TaskAttachment::create([
                'task_id' => $task->id,
                'file_path' => 'tasks/'.$task->id.'/desain.png',
                'type' => 'image',
                'original_name' => 'desain.png'
            ]);
        }
    }
}
