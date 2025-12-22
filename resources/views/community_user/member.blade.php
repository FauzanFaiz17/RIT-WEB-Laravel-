@extends('layouts.app')

@php
    use Illuminate\Support\HtmlString;

    $BackIcon = new HtmlString(
        '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.8333 10H4.16663" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 15.8333L4.16663 10L10 4.16663" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    );
    $AddIcon = new HtmlString(
        '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 4.16663V15.8333" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.16663 10H15.8333" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    );
@endphp

@section('content')
    {{-- Kontainer Utama: Padding disesuaikan untuk layar kecil (p-4) hingga besar (p-10) --}}
    <div class="mx-auto max-w-full p-4 md:p-6 2xl:p-10">

        {{-- HEADER SECTION: Menggunakan flex-col pada HP agar tombol turun ke bawah --}}
        <div class="flex flex-col gap-5 mb-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="w-full sm:w-auto">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Anggota {{ $name }}
                </h2>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ $divisionName }}
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Tombol Kembali --}}
                <a href="{{ $backUrl ?? route('dashboard') }}"
                    class="inline-flex flex-1 sm:flex-none items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    {!! $BackIcon !!}
                    <span>Kembali</span>
                </a>

                {{-- Tombol Tambah (Warna Dipaksa Biru) --}}
                <a href="{{ route('community_user.create', ['unit_id' => $currentUnitId]) }}"
                    class="inline-flex flex-1 sm:flex-none items-center justify-center gap-2 rounded-lg bg-[#3C50E0] px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-opacity-90 transition !bg-[#3C50E0] !text-white">
                    {!! $AddIcon !!}
                    <span class="!text-white whitespace-nowrap">Tambah Anggota</span>
                </a>
            </div>
        </div>

        {{-- TABLE SECTION --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            {{-- Wrapper ini (overflow-x-auto) yang membuat tabel bisa digeser di HP --}}
            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="w-full min-w-[800px] table-auto"> {{-- min-w diturunkan agar tidak terlalu lebar --}}
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                            <th class="px-5 py-4 text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">User
                            </th>
                            <th class="px-5 py-4 text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Jabatan</th>
                            <th class="px-5 py-4 text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">NPM
                            </th>
                            <th class="px-5 py-4 text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">Prodi
                            </th>
                            <th class="px-5 py-4 text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Semester</th>
                            <th class="px-5 py-4 text-right font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $data)
                            <tr
                                class="border-b border-gray-100 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 flex-shrink-0 overflow-hidden rounded-full border border-gray-200 dark:border-gray-700">
                                            @if ($data->user->foto_profil)
                                                <img src="{{ asset('storage/' . $data->user->foto_profil) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="flex h-full w-full items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-400 font-bold text-xs">
                                                    {{ strtoupper(substr($data->user->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span
                                                class="block font-medium text-gray-800 text-sm dark:text-white/90">{{ $data->user->name }}</span>
                                            <span
                                                class="block text-gray-500 text-xs dark:text-gray-400">{{ $data->user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    @php
                                        $statusClass = match ($data->role->name) {
                                            'Ketua'
                                                => 'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500',
                                            'Wakil Ketua'
                                                => 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-500',
                                            default
                                                => 'bg-gray-50 text-gray-700 dark:bg-gray-500/15 dark:text-gray-400',
                                        };
                                    @endphp
                                    <span
                                        class="text-theme-xs inline-block rounded-full px-2.5 py-1 font-medium {{ $statusClass }}">
                                        {{ $data->role->name }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $data->user->npm ?? '-' }}</td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $data->user->prodi ?? '-' }}</td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $data->user->semester ?? '-' }}</td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('community_user.edit', $data->id) }}"
                                            class="text-gray-500 hover:text-primary">
                                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.69 1.07l-3.266 1.053a.375.375 0 01-.48-.481L6.2 14.456a4.5 4.5 0 011.069-1.691l7.759-7.761c.229-.228.537-.228.766 0z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('community_user.destroy', $data->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-red-500">
                                                <svg class="size-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-gray-500">Belum ada anggota.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
