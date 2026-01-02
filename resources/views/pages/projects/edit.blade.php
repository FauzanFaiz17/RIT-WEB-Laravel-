@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Edit Project
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Perbarui informasi project
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

        <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- PROJECT NAME --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Project Name
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $project->name) }}"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2
                              focus:border-blue-500 focus:ring-blue-500
                              dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                       required>
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Description
                </label>
                <textarea name="description"
                          rows="4"
                          class="w-full rounded-lg border border-gray-300 px-4 py-2
                                 focus:border-blue-500 focus:ring-blue-500
                                 dark:border-gray-700 dark:bg-gray-900 dark:text-white">{{ old('description', $project->description) }}</textarea>
            </div>

            {{-- STATUS --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Status
                </label>
                <select name="status"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2
                               dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    <option value="active" @selected($project->status === 'active')>Active</option>
                    <option value="draft" @selected($project->status === 'draft')>Draft</option>
                    <option value="completed" @selected($project->status === 'completed')>Completed</option>"
                </select>
            </div>

            {{-- ACTION --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('projects.index') }}"
                   class="rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100
                          dark:text-gray-300 dark:hover:bg-gray-800">
                    Cancel
                </a>

                <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm
                               font-medium text-white hover:bg-blue-700">
                    Update Project
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
