@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    {{-- HEADER & NAVIGATION --}}
    <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Anggota {{ $name }}
            </h2>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Unit Induk: {{ $divisionName }}
            </p>
        </div>
        <div class="flex gap-3">
            {{-- Tombol Kembali --}}
            <a href="{{ $backUrl ?? route('dashboard') }}" 
               class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 12H5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 19L5 12L12 5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Kembali
            </a>

            {{-- Tombol Tambah --}}
            <a href="{{ route('community_user.create') }}" 
               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-blue-700">
               <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Anggota
            </a>
        </div>
    </div>

    {{-- TABLE CONTAINER (Alpine Data untuk interaksi Checkbox) --}}
    <div x-data="{
        selectedRows: [],
        selectAll: false,
        toggleAll() {
            this.selectAll = !this.selectAll;
            if (this.selectAll) {
                // Ambil semua ID dari data PHP yang di-render
                this.selectedRows = [{{ $members->pluck('id')->implode(',') }}];
            } else {
                this.selectedRows = [];
            }
        },
        toggleRow(id) {
            if (this.selectedRows.includes(id)) {
                this.selectedRows = this.selectedRows.filter(rowId => rowId !== id);
            } else {
                this.selectedRows.push(id);
            }
            // Update selectAll status
            this.selectAll = this.selectedRows.length === {{ $members->count() }};
        }
    }">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-white/[0.05] dark:bg-white/[0.03]">
            
            <div class="flex flex-col gap-4 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Daftar Mahasiswa
                    </h3>
                </div>
                {{-- Filter Button (Visual Only sesuai template) --}}
                <div class="flex items-center gap-3">
                    <button class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        <svg class="stroke-current fill-white dark:fill-gray-800" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z" fill="" stroke="" stroke-width="1.5"/>
                            <path d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z" fill="" stroke="" stroke-width="1.5"/>
                        </svg>
                        Filter
                    </button>
                </div>
            </div>

            <div class="max-w-full overflow-x-auto">
                <table class="w-full">
                    <thead class="px-6 py-3.5 border-t border-gray-100 border-y bg-gray-50 dark:border-white/[0.05] dark:bg-gray-900">
                        <tr>
                            {{-- Checkbox Header --}}
                            <th class="px-4 sm:px-6 py-3 font-medium text-gray-500 text-sm dark:text-gray-400 text-start w-20">
                                <div class="flex items-center gap-3">
                                    <div @click="toggleAll()"
                                        class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px]"
                                        :class="selectAll ? 'border-blue-500 dark:border-blue-500 bg-blue-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700'">
                                        <svg :class="selectAll ? 'block' : 'hidden'" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.6668 3.5L5.25016 9.91667L2.3335 7" stroke="white" stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-sm dark:text-gray-400 text-start">Mahasiswa</th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-sm dark:text-gray-400 text-start">Jabatan</th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-sm dark:text-gray-400 text-start">NPM</th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-sm dark:text-gray-400 text-start">Prodi</th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-sm dark:text-gray-400 text-start">Semester</th>
                            <th class="px-6 py-3 font-medium text-gray-500 text-sm dark:text-gray-400 text-start">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $data)
                            <tr class="border-b border-gray-100 dark:border-white/[0.05] hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                                {{-- Checkbox Row --}}
                                <td class="px-4 sm:px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div @click="toggleRow({{ $data->id }})"
                                            class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px]"
                                            :class="selectedRows.includes({{ $data->id }}) ? 'border-blue-500 dark:border-blue-500 bg-blue-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700'">
                                            <svg :class="selectedRows.includes({{ $data->id }}) ? 'block' : 'hidden'" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.6668 3.5L5.25016 9.91667L2.3335 7" stroke="white" stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                
                                {{-- Kolom Mahasiswa (Foto + Nama) --}}
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                                            @if($data->user->profile_photo_path)
                                                <img src="{{ asset('storage/' . $data->user->profile_photo_path) }}" 
                                                     alt="Foto" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="font-medium text-sm text-gray-500 dark:text-gray-400">
                                                    {{ substr($data->user->name, 0, 2) }}
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="mb-0.5 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                {{ $data->user->name }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $data->user->email }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom Jabatan (Pill Style) --}}
                                <td class="px-6 py-3.5">
                                    @php
                                        // Logika Warna Badge berdasarkan Jabatan
                                        $badgeClass = match($data->role->name) {
                                            'Ketua' => 'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500',
                                            'Wakil Ketua' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-500',
                                            'Sekretaris', 'Bendahara' => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400',
                                            default => 'bg-gray-50 text-gray-700 dark:bg-gray-500/15 dark:text-gray-400',
                                        };
                                    @endphp
                                    <span class="inline-block rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">
                                        {{ $data->role->name }}
                                    </span>
                                </td>

                                {{-- NPM --}}
                                <td class="px-6 py-3.5">
                                    <p class="text-sm text-gray-700 dark:text-gray-400">{{ $data->user->npm ?? '-' }}</p>
                                </td>

                                {{-- Prodi --}}
                                <td class="px-6 py-3.5">
                                    <p class="text-sm text-gray-700 dark:text-gray-400">{{ $data->user->prodi ?? '-' }}</p>
                                </td>

                                {{-- Semester --}}
                                <td class="px-6 py-3.5">
                                    <p class="text-sm text-gray-700 dark:text-gray-400">{{ $data->user->semester ?? '-' }}</p>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        {{-- Edit --}}
                                        <a href="{{ route('community_user.edit', $data->id) }}">
                                            <svg class="text-gray-500 cursor-pointer size-5 hover:text-blue-500 dark:text-gray-400 dark:hover:text-blue-500" 
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.69 1.07l-3.266 1.053a.375.375 0 01-.48-.481L6.2 14.456a4.5 4.5 0 011.069-1.691l7.759-7.761c.229-.228.537-.228.766 0z" />
                                            </svg>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('community_user.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                                <svg class="text-gray-500 cursor-pointer size-5 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-500" 
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada anggota yang terdaftar di divisi ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection