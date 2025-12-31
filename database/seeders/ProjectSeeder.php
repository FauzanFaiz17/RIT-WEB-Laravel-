<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::Create([
            'user_id' => 1,
            'name' => 'Project RIT',
            'description' => 'WKWKKWKKWK',
            'status' => 'active',
        ]);
        Project::Create([
            'user_id' => 2,
            'name' => 'Project ABC',
            'description' => 'Description for Project ABC',
            'status' => 'draft',
        ]);
    }
}
