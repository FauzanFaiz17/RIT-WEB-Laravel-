<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Controller
{
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
            'tasks.*.done' => 'nullable|boolean',
            'tasks.*.subtasks' => 'nullable|array',
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
                    $task = $project->tasks()->create([
                        'title' => $taskData['title'],
                        'description' => $taskData['description'] ?? null,
                        'start_date' => $taskData['start_date'] ?? null,
                        'end_date' => $taskData['end_date'] ?? null,
                        'progress' => !empty($taskData['done']) ? 100 : ($taskData['progress'] ?? 0),
                        'done' => !empty($taskData['done']),
                    ]);

                    foreach ($subtasks as $sub) {
                        $task->children()->create([
                            'title' => $sub['title'],
                            'description' => $sub['description'] ?? null,
                            'start_date' => $sub['start_date'] ?? null,
                            'end_date' => $sub['end_date'] ?? null,
                            'progress' => !empty($sub['done']) ? 100 : ($sub['progress'] ?? 0),
                            'done' => !empty($sub['done']),
                        ]);
                    }
                }
            }

            return $project;
        });

        return redirect()->route('projects.index')->with('success', 'Project berhasil dibuat');
    }

    public function addTask(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'progress' => 'nullable|integer|min:0|max:100',
            'done' => 'nullable|boolean',
            'parent_id' => 'nullable|integer',
        ]);

        // if parent_id provided, ensure it belongs to this project
        if (!empty($validated['parent_id'])) {
            $exists = $project->tasks()->where('id', $validated['parent_id'])->exists();
            if (!$exists) {
                return back()->withErrors(['parent_id' => 'Invalid parent task for this project']);
            }
        }

        $task = $project->tasks()->create([
            'parent_id' => $validated['parent_id'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'progress' => !empty($validated['done']) ? 100 : ($validated['progress'] ?? 0),
            'done' => !empty($validated['done']),
        ]);



        return back()->with('success', 'Task berhasil ditambahkan');
    }
    public function editTask(Project $project, Task $task)
    {
        if ($task->project_id !== $project->id) {
            abort(404);
        }

        return view('pages.projects.tasks.edit', compact('project', 'task'));
    }

    public function updateTask(Request $request, Project $project, Task $task)
    {
        if ($task->project_id !== $project->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'progress' => 'nullable|integer|min:0|max:100',
            'done' => 'nullable|boolean',
        ]);

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'progress' => !empty($validated['done']) ? 100 : ($validated['progress'] ?? 0),
            'done' => !empty($validated['done']),
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Task berhasil diperbarui');
    }

    public function editSubtask(Project $project, Task $task, Task $subtask)
    {
        if ($task->project_id !== $project->id || $subtask->project_id !== $project->id || $subtask->parent_id !== $task->id) {
            abort(404);
        }

        return view('pages.projects.tasks.edit-subtask', compact('project', 'task', 'subtask'));
    }

    public function updateSubtask(Request $request, Project $project, Task $task, Task $subtask)
    {
        if ($task->project_id !== $project->id || $subtask->project_id !== $project->id || $subtask->parent_id !== $task->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'progress' => 'nullable|integer|min:0|max:100',
            'done' => 'nullable|boolean',
        ]);

        $subtask->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'progress' => !empty($validated['done']) ? 100 : ($validated['progress'] ?? 0),
            'done' => !empty($validated['done']),
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Subtask berhasil diperbarui');
    }

  public function show(Project $project)
{
    $project->load([
        'user',
        'tasks' => function ($q) {
            $q->whereNull('parent_id')
              ->with([
                  'users',
                  'subtasks.users'
              ]);
        }
    ]);

    return view('pages.projects.show', compact('project'));
}


public function edit(Project $project)
    {
        return view('pages.projects.edit', compact('project'));
    }

        public function destroy(Project $project)
    {
        // Deleting project will cascade to tasks (DB foreign key)
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus');
    }
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,draft,completed',
        ]);

        $project->update($validated);

        return redirect()
            ->route('projects.index', $project)
            ->with('success', 'Project berhasil diperbarui');
    }
} 

