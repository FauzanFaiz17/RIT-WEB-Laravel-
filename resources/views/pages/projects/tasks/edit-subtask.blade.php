@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-lg p-4">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Edit Subtask</h2>
            <p class="text-sm text-white">Parent task: <span class="font-medium text-white">{{ $task->title }}</span></p>
        </div>
        <a href="{{ route('projects.show', $project) }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm text-white hover:bg-brand-600">Back</a>
    </div>

    <div class="rounded-xl border border-gray-200 bg-gray p-6 dark:border-gray-800">
        <form action="{{ route('projects.tasks.subtasks.update', [$project, $task, $subtask]) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium text-white">Title</label>
                <input type="text" name="title" value="{{ old('title', $subtask->title) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2
                                 focus:border-blue-500 focus:ring-blue-500
                                 dark:border-gray-700 dark:bg-gray-900 dark:text-white" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-white">Description</label>
                <textarea name="description" rows="4" class="w-full rounded-lg border border-gray-300 px-4 py-2
                                 focus:border-blue-500 focus:ring-blue-500
                                 dark:border-gray-700 dark:bg-gray-900 dark:text-white">{{ old('description', $subtask->description) }}</textarea>
            </div>

            

            <div>
                <label class="block text-sm font-medium text-white">Progress (%)</label>
                <input type="number" name="progress" min="0" max="100" value="{{ old('progress', $subtask->progress) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2
                                 focus:border-blue-500 focus:ring-blue-500
                                 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-white">Status</label>
                <select name="status"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2
                        focus:border-blue-500 focus:ring-blue-500
                        dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    <option value="todo" {{ old('status', $subtask->status) === 'todo' ? 'selected' : '' }}>
                        To Do
                    </option>
                    <option value="in_progress" {{ old('status', $subtask->status) === 'in_progress' ? 'selected' : '' }}>
                        In Progress
                    </option>
                    <option value="done" {{ old('status', $subtask->status) === 'done' ? 'selected' : '' }}>
                        Done
                    </option>
                </select>
            </div>


            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('projects.show', $project) }}" class="rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Cancel</a>
                <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-sm text-white hover:bg-brand-600">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection