<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectController extends Controller
{

    public function show(Project $project)
    {
        // Ambil SEMUA task project (tanpa filter parent)
        $tasks = $project->tasks()
            ->with('users')
            ->orderBy('start_date')
            ->get();

        $users = User::select('id', 'name')->get();

        // Recursive tree builder
        $rows = $this->buildTaskTree($tasks);

        return view('pages.projects.show', compact(
            'project',
            'users',
            'rows'
        ));
    }

    // 🔁 Helper recursive
    private function buildTaskTree($tasks, $parentId = null, $level = 0)
    {
        $rows = [];

        foreach ($tasks->where('parent_id', $parentId) as $task) {
            $rows[] = [
                'data'  => $task,
                'level' => $level,
            ];

            $rows = array_merge(
                $rows,
                $this->buildTaskTree($tasks, $task->id, $level + 1)
            );
        }

        return $rows;
    }



   public function index()
    {
    $projects = Project::with('user')->latest()->get();

    return view('pages.projects.project', compact('projects'));
    }

    public function create()
    {
        return view('pages.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,active,completed',
            // optional owner id (useful when auth is not required)
            'user_id' => 'nullable|exists:users,id',
            'tasks' => 'nullable|array',
            'tasks.*.title' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
            'tasks.*.start_date' => 'nullable|date',
            'tasks.*.end_date' => 'nullable|date',
            'tasks.*.progress' => 'nullable|integer|min:0|max:100',
            'tasks.*.status' => 'nullable|in:todo,in_progress,done',
            'tasks.*.subtasks.*.status' => 'nullable|in:todo,in_progress,done',
            'tasks.*.subtasks.*.title' => 'required|string|max:255',
            'tasks.*.subtasks.*.description' => 'nullable|string',
            'tasks.*.subtasks.*.start_date' => 'nullable|date',
            'tasks.*.subtasks.*.end_date' => 'nullable|date',
            'tasks.*.subtasks.*.progress' => 'nullable|integer|min:0|max:100',
            'tasks.*.subtasks.*.done' => 'nullable|boolean',
        ]);

        // Use provided user_id if present; otherwise default to 1 (no auth required)
        $userId = (int) $request->input('user_id', 1);

        $project = DB::transaction(function () use ($validated, $userId) {
            $project = Project::create([
                'user_id' => $userId,
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
            ]);

            if (!empty($validated['tasks'])) {
                foreach ($validated['tasks'] as $taskData) {
                    $subtasks = $taskData['subtasks'] ?? [];
                    $taskStatus = $taskData['status'] ?? 'todo';
                    $task = $project->tasks()->create([
                        'title' => $taskData['title'],
                        'description' => $taskData['description'] ?? null,
                        'start_date' => $taskData['start_date'] ?? null,
                        'end_date' => $taskData['end_date'] ?? null,
                        'status' => $taskStatus,
                        'progress' => $taskStatus === 'done' ? 100 : ($taskData['progress'] ?? 0),
                    ]);


                    foreach ($subtasks as $sub) {
                        $subStatus = $sub['status'] ?? 'todo';
                        $task->subtask()->create([
                            'title' => $sub['title'],
                            'description' => $sub['description'] ?? null,
                            'start_date' => $sub['start_date'] ?? null,
                            'end_date' => $sub['end_date'] ?? null,
                            'status' => $subStatus,
                            'progress' => $subStatus === 'done' ? 100 : ($sub['progress'] ?? 0),
                        ]);

                    }
                }
            }

            return $project;
        });

        return redirect()->route('projects.index')->with('success', 'Project berhasil dibuat');
    }





    public function edit(Project $project)
    {
        return view('pages.projects.edit', compact('project'));
    }

    
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|string',
        ]);

        $project->update($request->only([
            'name',
            'description',
            'status',
        ]));

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Project berhasil diperbarui');
    }





    public function destroy(Project $project)
    {
        // Deleting project will cascade to tasks (DB foreign key)
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus');
    }
} 

