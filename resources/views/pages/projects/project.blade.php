@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        List Project
    </h2>

    <a
        href="{{ route('projects.create') }}"
        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4" />
        </svg>
        Create Project
    </a>
</div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[1102px]">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                User
                            </p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Project Name
                            </p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Status
                            </p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Created At
                            </p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Updated At
                            </p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Actions
                            </p>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($projects as $project)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            {{-- USER --}}
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 overflow-hidden rounded-full">
                                        <img
                                            src="{{ $project->user?->foto_profil
                                                ? asset('storage/'.$project->user->foto_profil)
                                                : asset('images/user/default.png') }}"
                                            alt="user"
                                        >
                                    </div>
                                    <div>
                                        <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                            {{ $project->user->name ?? '-' }}
                                        </span>
                                        <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                            @switch($project->user->prodi ?? '')
                                                @case('TI') Teknologi informasi @break
                                                @case('RPL') Rekayasa perangkat lunak @break
                                                @case('RSK') Rekayasa sistem komputer @break
                                                @case('ILKOM') Ilmu komunikasi @break
                                                @default -
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- PROJECT NAME --}}
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $project->name }}
                                </p>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-5 py-4 sm:px-6">
                                @php
                                    $statusClass = match ($project->status) {
                                        'active'  => 'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500',
                                        'draft' => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400',
                                        'completed'  => 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-500',
                                        default   => '',
                                    };
                                @endphp
                                <span class="inline-block rounded-full px-2 py-0.5 text-theme-xs font-medium {{ $statusClass }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>

                            {{-- CREATED --}}
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $project->created_at->format('d M Y') }}
                                </p>
                            </td>

                            {{-- UPDATED --}}
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $project->updated_at->format('d M Y') }}
                                </p>
                            </td>

                            {{-- ACTION --}}
                           <td class="px-5 py-4 sm:px-6">
    <div class="flex items-center gap-3">
        <a
            href="{{ route('projects.show', $project->id) }}"
            class="text-brand-500 hover:underline"
        >
            View
        </a>

       <a href="{{ route('projects.edit', $project) }}"
   class="text-blue-600 hover:underline dark:text-blue-400">
    Edit
</a>

        <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button
                type="submit"
                onclick="return confirm('Delete this project?')"
                class="text-red-600 hover:underline dark:text-red-400"
            >
                Delete
            </button>
        </form>
    </div>
</td>

                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500 dark:text-gray-400">
                                No projects found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
