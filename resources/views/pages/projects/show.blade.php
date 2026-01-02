@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Project Detail" />

<div class="space-y-6">

    @if(session('success'))
        <div class="rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-start justify-between gap-6">
        <div class="flex-1">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $project->name }}</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $project->description ?? 'No description' }}</p>

            <div class="mt-4 flex items-center gap-3">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-8 overflow-hidden rounded-full">
                        <img src="{{ $project->user?->foto_profil ? asset('storage/'.$project->user->foto_profil) : asset('images/user/default.png') }}" alt="owner">
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-800 dark:text-white">{{ $project->user->name ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $project->created_at->format('d M Y') }}</div>
                    </div>
                </div>

                <div class="ml-4 flex items-center gap-2">
                    @php
                        $statusClass = match ($project->status) {
                            'active' => 'bg-brand-100 text-brand-700 dark:bg-brand-500/15 dark:text-brand-300',
                            'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/15 dark:text-yellow-400',
                            default => 'bg-gray-100 text-gray-800 dark:bg-white/5 dark:text-gray-300',
                        };
                    @endphp
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ $statusClass }}">{{ ucfirst($project->status) }}</span>
                </div>
            </div>
        </div>

        <div class="flex-shrink-0 flex gap-2">
            <a href="{{ route('projects.edit', $project) }}" class="rounded-md bg-brand-500 px-4 py-2 text-white hover:bg-brand-600">Edit</a>
            <a href="{{ route('projects.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300">Back</a>
        </div>
    </div>

    {{-- Content: left sidebar + main area --}}
    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
        {{-- Sidebar --}}
        <aside class="col-span-1 md:col-span-1">
            <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.02]">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Properties</h3>

                <dl class="mt-3 space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    <div>
                        <dt class="text-xs text-gray-500">Owner</dt>
                        <dd class="font-medium text-gray-800 dark:text-white">{{ $project->user->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Created</dt>
                        <dd>{{ $project->created_at->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Updated</dt>
                        <dd>{{ $project->updated_at->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Tasks</dt>
                        <dd class="font-medium">{{ $project->tasks->whereNull('parent_id')->count() }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Quick Add Task</h4>
                    <form action="{{ route('projects.tasks.store', $project) }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $project->user_id ?? 1 }}">
                        <input type="hidden" name="status" value="{{ $project->status }}">
                        <div class="space-y-2">
                            <input name="title" placeholder="Task title" class="w-full rounded-md border px-3 py-2 text-sm bg-gray-50 dark:bg-white/3 dark:text-white">
                            <button type="submit" class="w-full rounded-md bg-brand-500 px-3 py-2 text-sm text-white hover:bg-brand-600">Add Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main column --}}
        <div class="col-span-1 md:col-span-3">
            <div class="space-y-4">
                @forelse ($project->tasks->whereNull('parent_id') as $task)
                    <div x-data="{ open: true, done: {{ $task->done ? 'true' : 'false' }} }" class="rounded-md border border-gray-200 bg-white dark:bg-white/[0.03] p-4 dark:border-gray-800">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center rounded-full text-xs font-medium px-2 py-0.5 {{ $task->done ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ $task->done ? 'Done' : 'Pending' }}</span>
                                </div>

                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $task->title }}</h4>
                                    @if($task->description)
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $task->description }}</p>
                                    @endif

                                    <div class="mt-3 flex items-center gap-3 text-sm text-gray-500">
                                        <div class="flex items-center gap-2">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-gray-400"><path d="M12 8v4l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            <span>{{ $task->start_date ? $task->start_date->format('d M') : '-' }} — {{ $task->end_date ? $task->end_date->format('d M') : '-' }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-gray-400"><path d="M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z" stroke="currentColor" stroke-width="1.5"/></svg>
                                            <span>{{ $task->done ? 100 : $task->progress }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <button @click="open = !open" class="text-sm text-gray-500">Toggle</button>
                                <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-sm text-brand-500">Edit</a>
                            </div>
                        </div>

                        <div x-show="open" x-transition class="mt-4">
                            {{-- Progress bar --}}
                            <div class="h-2 w-full rounded-full bg-gray-100 dark:bg-white/[0.02]">
                                <div class="h-2 rounded-full bg-brand-500" style="width: {{ $task->done ? 100 : $task->progress }}%"></div>
                            </div>

                            {{-- Subtasks --}}
                            <div class="mt-3 space-y-2">
                                @foreach ($task->children as $sub)
                                    <div class="flex items-center justify-between rounded-md border border-gray-100 bg-white dark:bg-white/[0.02] p-3">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex items-center rounded-full text-xs font-medium px-2 py-0.5 {{ $sub->done ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ $sub->done ? 'Done' : 'Pending' }}</span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800 dark:text-white">{{ $sub->title }}</div>
                                                @if($sub->description)
                                                    <div class="text-xs text-gray-500">{{ $sub->description }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="text-sm text-gray-500">{{ $sub->done ? 100 : $sub->progress }}%</div>
                                            <a href="{{ route('projects.tasks.subtasks.edit', [$project, $task, $sub]) }}" class="text-xs text-brand-500">Edit</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Add subtask form --}}
                            <div class="mt-3">
                                <form action="{{ route('projects.tasks.store', $project) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $task->id }}">
                                    <input type="text" name="title" placeholder="New subtask title" class="flex-1 rounded-md border px-3 py-2 text-sm bg-gray-50 dark:bg-white/3 dark:text-white">
                                    <button type="submit" class="rounded-md bg-brand-500 px-3 py-2 text-sm text-white hover:bg-brand-600">Add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">No tasks yet</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
