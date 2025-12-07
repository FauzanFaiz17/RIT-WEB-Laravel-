<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $project = Project::first();

        // Task utama
        $task1 = Task::create([
            'project_id' => $project->id,
            'title' => 'Membuat Halaman Dashboard',
            'description' => 'Pembuatan halaman dashboard utama.',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'progress' => 20,
            'is_done' => false,
        ]);

        // Subtask
        $sub1 = Task::create([
            'project_id' => $project->id,
            'parent_id' => $task1->id,
            'title' => 'Desain UI Dashboard',
            'description' => 'Membuat tampilan UI.',
            'start_date' => now(),
            'end_date' => now()->addDays(3),
            'progress' => 40,
        ]);

        $sub2 = Task::create([
            'project_id' => $project->id,
            'parent_id' => $task1->id,
            'title' => 'Implementasi Frontend',
            'description' => 'Implementasi menggunakan Tailwind + Vue/React.',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(7),
            'progress' => 10,
        ]);

        // assign user ke task (jika sudah ada user)
        $user = User::first();
        if ($user) {
            $task1->users()->attach($user->id);
            $sub1->users()->attach($user->id);
        }
    }
}
