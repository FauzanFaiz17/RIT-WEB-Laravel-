<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
        public function index()
    {
        // Ambil semua project (jika perlu pagination bisa ditambah)
        $projects = Project::withCount('tasks')->get();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        // Ambil semua task + subtask (nested)
        $project->load([
            'tasks' => function ($q) {
                $q->whereNull('parent_id'); // hanya task utama
            },
            'tasks.subtasks' // load subtask
        ]);

        return view('projects.show', compact('project'));
    }
    
    public function gantt(Project $project)
    {
        // ambil task + subtask datanya
        $tasks = $project->tasks()
            ->with('subtasks')
            ->whereNull('parent_id')
            ->get();

        return view('projects.gantt', compact('project', 'tasks'));
    }

}
