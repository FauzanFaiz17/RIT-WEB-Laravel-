<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::Create([
            'project_id' => 2,
            'title' => 'Initial Task',
            'description' => 'This is the first task for Project RIT',
            'start_date' => '2025-12-15',
            'end_date' => '2025-12-20',
            'progress' => 0,
            'is_done' => false,
        ]);
        Task::Create([
            'project_id' => 3,
            'title' => 'Second Task',
            'description' => 'This is the second task for Project RIT',
            'start_date' => '2025-12-21',
            'end_date' => '2025-12-25',
            'progress' => 100,
            'is_done' => true,
        ]);
        Task::Create([
            'project_id' => 2,
            'title' => 'Initial Task for ABC',
            'description' => 'This is the first task for Project ABC',
            'start_date' => '2025-12-16',
            'end_date' => '2025-12-22',
            'progress' => 50,
            'is_done' => false,
        ]);
        Task::Create([
            'project_id' => 2,
            'parent_id' => 3,
            'title' => 'Subtask for ABC',
            'description' => 'This is a subtask for the first task of Project ABC',
            'start_date' => '2025-12-17',
            'end_date' => '2025-12-20',
            'progress' => 20,
            'is_done' => false,
        ]);
    }
}
