<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;

class TaskController extends Controller
{
    /**
     * STORE task / subtask
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:tasks,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'users'       => 'nullable|array',
            'status'      => 'required|string',
            'progress'    => 'nullable|integer|min:0|max:100',
        ]);

        // ✅ BUAT TASK LEWAT RELASI PROJECT
        $task = $project->tasks()->create([
            'parent_id'   => $request->parent_id,
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => $request->status,
            'progress'    => $request->progress ?? 0,
        ]);

        // ✅ SYNC USERS (task_user)
        if ($request->filled('users')) {
            $result = $task->users()->sync($request->users);

            // 🔔 Kirim notifikasi hanya ke user BARU
            if (!empty($result['attached'])) {
                $users = User::whereIn('id', $result['attached'])->get();

                foreach ($users as $user) {
                    $user->notify(new TaskAssignedNotification($task));
                }
            }
        }
        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Task berhasil ditambahkan');
    }


    /**
     * UPDATE task / subtask
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:tasks,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'users'       => 'nullable|array',
            'status'      => 'required|string',
            'progress'    => 'nullable|integer|min:0|max:100',
        ]);


        $task->update([
            'title'       => $request->title,
            'description' => $request->description,
            'parent_id'   => $request->parent_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => $request->status,
            'progress'    => $request->progress ?? 0,
        ]);


        // Ambil user sebelum sync
        $beforeUserIds = $task->users()->pluck('users.id')->toArray();

        // Sync baru
        $task->users()->sync($request->users ?? []);

        // Ambil user setelah sync
        $afterUserIds = $task->users()->pluck('users.id')->toArray();

        // User BARU saja
        $newUserIds = array_diff($afterUserIds, $beforeUserIds);

        // Kirim notifikasi
        $users = User::whereIn('id', $newUserIds)->get();
        foreach ($users as $user) {
            $user->notify(new TaskAssignedNotification($task));
        }

        return redirect()
            ->back()
            ->with('success', 'Task berhasil diperbarui');
    }



    /**
     * DELETE task + subtasks
     */
    public function destroy(Task $task)
    {
        DB::transaction(function () use ($task) {
            $this->deleteTaskRecursive($task);
        });

        return redirect()
            ->route('projects.show', $task->project_id)
            ->with('success', 'Task & seluruh subtask berhasil dihapus');
    }

    private function deleteTaskRecursive(Task $task)
    {
        // Hapus semua child terlebih dahulu
        foreach ($task->subtasks as $child) {
            $this->deleteTaskRecursive($child);
        }

        // Detach pivot users
        $task->users()->detach();

        // Hapus task
        $task->delete();
    }


    // untuk kanban
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task status updated',
        ]);
    }

}
