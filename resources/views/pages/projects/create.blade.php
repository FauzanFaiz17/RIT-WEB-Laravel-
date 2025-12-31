@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Create Project
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Buat project baru beserta task dan subtask
            </p>
        </div>

        <a href="{{ route('projects.index') }}"
           class="rounded-lg border border-gray-300 px-4 py-2 text-sm
                  text-gray-700 hover:bg-gray-100
                  dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
            Kembali
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6
                dark:border-gray-800 dark:bg-white/[0.03]">

        <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
            @csrf

            @if ($errors->any())
                <div class="rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- PROJECT INFO --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Project Name
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2
                              focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-white/3 dark:text-white"
                       required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Description
                </label>
                <textarea name="description"
                          rows="4"
                          class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2
                                 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-white/3 dark:text-white">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Status
                </label>
                <select name="status"
                        class="w-full rounded-lg border border-blue bg-blue px-4 py-2
                               focus:border-blue focus:ring-blue dark:border-blue dark:bg-white/3 dark:text-white">
                    <option value="active" @selected(old('status') === 'active')>Active</option>
                    <option value="draft" @selected(old('status') === 'draft')>Draft</option>
                    <option value="completed" @selected(old('status') === 'completed')>Completed</option>
                </select>
            </div>

            {{-- DYNAMIC TASKS --}}
            <div x-data="projectTasks(@json(old('tasks', [])))" class="space-y-4">
                <template x-for="(task, tIndex) in tasks" :key="tIndex">
                    <div class="rounded-lg border border-gray-200 bg-white dark:bg-white/[0.03] p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                    Task
                                    <span class="ml-2 inline-block rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-white/[0.03] dark:text-gray-300"
                                          x-text="tIndex + 1"></span>
                                </h4>
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="button" @click="addSubtask(tIndex)" class="text-sm text-brand-500 hover:text-brand-600">+ Subtask</button>
                                <button type="button" @click="removeTask(tIndex)" class="text-sm text-red-500 hover:text-red-600">Remove</button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-3 mt-3">
                            <input type="text" :name="`tasks[${tIndex}][title]`" x-model="task.title" placeholder="Title"
                                   class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 dark:bg-white/3 dark:text-white">

                            <textarea :name="`tasks[${tIndex}][description]`" x-model="task.description" placeholder="Description" rows="3"
                                      class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 dark:bg-white/3 dark:text-white"></textarea>

                            <div class="grid grid-cols-2 gap-3">
                                <input type="date" :name="`tasks[${tIndex}][start_date]`" x-model="task.start_date"
                                       class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 dark:bg-white/3 dark:text-white">
                                <input type="date" :name="`tasks[${tIndex}][end_date]`" x-model="task.end_date"
                                       class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 dark:bg-white/3 dark:text-white">
                            </div>

                            <div class="flex items-center gap-4">
                                <input type="number" min="0" max="100" :name="`tasks[${tIndex}][progress]`" x-model="task.progress"
                                       class="w-24 rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 dark:bg-white/3 dark:text-white" placeholder="Progress %">
                            </div>

                            {{-- SUBTASKS --}}
                            <div class="mt-2 space-y-2">
                                <template x-for="(sub, sIndex) in task.subtasks" :key="sIndex">
                                    <div class="rounded border border-gray-100 bg-white dark:bg-white/[0.02] p-3">
                                        <div class="flex items-center justify-between">
                                            <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300">Subtask <span class="ml-2 text-xs text-gray-500 dark:text-gray-400" x-text="sIndex + 1"></span></h5>
                                            <button type="button" @click="removeSubtask(tIndex, sIndex)" class="text-sm text-red-500 hover:text-red-600">Remove</button>
                                        </div>

                                        <div class="mt-2 grid grid-cols-1 gap-2">
                                            <input type="text" :name="`tasks[${tIndex}][subtasks][${sIndex}][title]`" x-model="sub.title" placeholder="Title"
                                                   class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 dark:bg-white/3 dark:text-white">
                                            <textarea :name="`tasks[${tIndex}][subtasks][${sIndex}][description]`" x-model="sub.description" placeholder="Description" rows="2"
                                                      class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 dark:bg-white/3 dark:text-white"></textarea>
                                        </div>
                                    </div>
                                </template>
                            </div>

                        </div>
                    </div>
                </template>

                <div class="flex gap-3">
                    <button type="button" @click="addTask()" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">Add Task</button>
                </div>
            </div>

            {{-- ACTION --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('projects.index') }}"
                   class="rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100
                          dark:text-gray-300 dark:hover:bg-gray-800">
                    Cancel
                </a>

                <button type="submit"
                        class="rounded-lg bg-brand-500 px-4 py-2 text-sm
                               font-medium text-white hover:bg-brand-600">
                    Create Project
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function projectTasks(initial = []) {
    // Normalize incoming data and ensure fields exist
    const normalize = (t) => ({
        title: t.title ?? '',
        description: t.description ?? '',
        start_date: t.start_date ?? '',
        end_date: t.end_date ?? '',
        progress: t.progress ?? 0,
        done: !!t.done,
        subtasks: (t.subtasks ?? []).map(s => ({
            title: s.title ?? '',
            description: s.description ?? '',
            start_date: s.start_date ?? '',
            end_date: s.end_date ?? '',
            progress: s.progress ?? 0,
            done: !!s.done
        }))
    });

    return {
        tasks: (initial ?? []).map(normalize),
        addTask() {
            this.tasks.push({
                title: '',
                description: '',
                start_date: '',
                end_date: '',
                progress: 0,
                done: false,
                subtasks: []
            });
        },
        removeTask(i) {
            this.tasks.splice(i, 1);
        },
        addSubtask(taskIndex) {
            this.tasks[taskIndex].subtasks.push({
                title: '',
                description: '',
                start_date: '',
                end_date: '',
                progress: 0,
                done: false
            });
        },
        removeSubtask(taskIndex, subIndex) {
            this.tasks[taskIndex].subtasks.splice(subIndex, 1);
        }
    }
}
</script>

@endsection
