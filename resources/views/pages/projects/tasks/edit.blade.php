@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-lg p-4">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Edit Task</h2>
        <a href="{{ route('projects.show', $project) }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm text-white hover:bg-brand-600">Back</a>
    </div>

    <div class="rounded-xl border border-gray-200 bg-blue p-6 dark:border-gray-800">
        <form action="{{ route('projects.tasks.update', [$project, $task]) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="blocktext-sm font-medium text-white hover:bg-brand-600">Title</label>
                <input type="text" name="title" value="{{ old('title', $task->title) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2
                                 focus:border-blue-500 focus:ring-blue-500
                                 dark:border-gray-700 dark:bg-gray-900 dark:text-white" required>
            </div>

            <div>
                <label class="block sm font-medium text-white hover:bg-brand-600">Description</label>
                <textarea name="description" rows="4" class="w-full rounded-lg border border-gray-300 px-4 py-2
                                 focus:border-blue-500 focus:ring-blue-500
                                 dark:border-gray-700 dark:bg-gray-900 dark:text-white">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-white hover:bg-brand-600">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', optional($task->start_date)->format('Y-m-d')) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2
                                 focus:border-blue-500 focus:ring-blue-500
                                 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white hover:bg-brand-600">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', optional($task->end_date)->format('Y-m-d')) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2
                                 focus:border-blue-500 focus:ring-blue-500
                                 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-white hover:bg-brand-600">Progress (%)</label>
                <input type="number" name="progress" min="0" max="100" value="{{ old('progress', $task->progress) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2
                                 focus:border-blue-500 focus:ring-blue-500
                                 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-white">Status</label>
                <select name="status"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2
                        focus:border-blue-500 focus:ring-blue-500
                        dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    <option value="todo" {{ old('status', $task->status) === 'todo' ? 'selected' : '' }}>
                        To Do
                    </option>
                    <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>
                        In Progress
                    </option>
                    <option value="done" {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>
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
