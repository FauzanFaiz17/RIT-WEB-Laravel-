@extends('layouts.app')

@php
    // Jika nama divisi cocok key, pakai icon tersebut. Jika tidak, pakai default.
    function getIconPath($name)
    {
        $name = strtolower($name);
        if (str_contains($name, 'web')) {
            return '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />'; // Mata/Web
        } elseif (str_contains($name, 'mobile') || str_contains($name, 'android') || str_contains($name, 'ios')) {
            return '<path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v16a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 18a1 1 0 100-2 1 1 0 000 2zm-1-4V5h6v11H9z" clip-rule="evenodd" />'; // HP
        } elseif (str_contains($name, 'data') || str_contains($name, 'ai')) {
            return '<path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" /><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />'; // Chart
        } elseif (str_contains($name, 'game')) {
            return '<path d="M11 2a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1h-6a1 1 0 01-1-1V2zM11 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1h-6a1 1 0 01-1-1v-6zM4 2a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1V2zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z" />'; // Kotak/Pixel
        }
        return '<path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />';
    }
@endphp

@section('content')
    <div class="mx-auto max-w-7xl">

        {{-- HEADER & BREADCRUMB --}}
        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ $communityName }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Pilih divisi untuk melihat atau mengelola anggotanya.
                </p>
            </div>

            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium text-gray-500 hover:text-brand-500" href="#">Dashboard /</a></li>
                    <li><a class="font-medium text-gray-500 hover:text-brand-500" href="#">Komunitas /</a></li>
                    <li class="font-medium text-brand-500">{{ $communityName }}</li>
                </ol>
            </nav>
        </div>

        {{-- GRID CARD DIVISI --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($divisions as $div)
                {{-- CARD ITEM --}}
                <a href="{{ route('member.list', $div->name) }}"
                    class="group relative flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs transition-all duration-300 hover:border-brand-300 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-brand-700">

                    {{-- Icon & Header --}}
                    <div class="mb-4">
                        <div
                            class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white dark:bg-white/5 dark:text-blue-400 dark:group-hover:bg-blue-600 dark:group-hover:text-white">
                            <svg class="h-7 w-7 fill-current" viewBox="0 0 20 20">
                                {!! getIconPath($div->name) !!}
                            </svg>
                        </div>

                        <h3
                            class="text-xl font-bold text-gray-800 transition-colors group-hover:text-brand-500 dark:text-white">
                            {{ $div->name }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2 dark:text-gray-400">
                            Kelola anggota dan kegiatan divisi {{ $div->name }}.
                        </p>
                    </div>

                    {{-- Footer / Action Arrow --}}
                    <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4 dark:border-gray-800">
                        <span class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500">
                            Lihat Detail
                        </span>
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-50 text-gray-400 transition-all group-hover:bg-brand-500 group-hover:text-white dark:bg-white/5 dark:group-hover:bg-brand-500">
                            <svg class="h-5 w-5 -rotate-45 transform transition-transform group-hover:rotate-0"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </span>
                    </div>
                </a>

            @empty
                {{-- EMPTY STATE (JIKA TIDAK ADA DIVISI) --}}
                <div
                    class="col-span-full flex flex-col items-center justify-center rounded-2xl border border-dashed border-gray-300 bg-gray-50 py-12 text-center dark:border-gray-700 dark:bg-gray-900/50">
                    <div class="rounded-full bg-gray-100 p-3 dark:bg-gray-800">
                        <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada divisi</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Belum ada divisi yang terdaftar di komunitas
                        ini.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
