<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Project::create([
            'name' => 'Sistem Manajemen Organisasi',
            'description' => 'Project utama untuk pengembangan aplikasi organisasi.',
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(30),
            'status' => 'active',
        ]);
    }
}
