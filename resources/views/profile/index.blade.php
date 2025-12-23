@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-270">

        {{-- HEADER & BREADCRUMB --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-gray-800 dark:text-white">
                Profil Saya
            </h2>
            <nav>
                <ol class="flex items-center gap-2 text-sm">
                    <li><a class="font-medium hover:text-brand-500" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li class="font-medium text-brand-500">Profil</li>
                </ol>
            </nav>
        </div>

        {{-- WRAPPER UTAMA (PENTING: x-data membungkus semua kartu dan modal) --}}
        <div x-data="{ editModalOpen: false }" class="space-y-6">

            {{-- 1. KARTU PROFIL ATAS (FOTO, INFO IDENTITAS, DAN TOMBOL UPLOAD) --}}
            <div
                class="p-5 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 bg-white dark:bg-gray-900 shadow-theme-xs">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

                    {{-- BAGIAN KIRI: FOTO + IDENTITAS (Nama, NPM, & Jabatan | Unit) --}}
                    <div class="flex items-center gap-5">
                        {{-- Avatar --}}
                        <div
                            class="relative w-20 h-20 sm:w-24 sm:h-24 overflow-hidden rounded-full border-4 border-gray-100 dark:border-gray-800 shrink-0">
                            @if ($user->foto_profil)
                                {{-- Menggunakan kolom foto_profil sesuai database Anda --}}
                                <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Profile Photo"
                                    class="h-full w-full object-cover">
                            @else
                                <div
                                    class="flex h-full w-full items-center justify-center bg-gray-100 text-gray-400 dark:bg-gray-800">
                                    <span class="text-2xl font-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Detail Identitas --}}
                        <div class="flex flex-col">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white/90 sm:text-2xl">
                                {{ $user->name }}
                            </h3>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                NPM: <span class="text-gray-700 dark:text-gray-200">{{ $user->npm ?? '-' }}</span>
                            </p>

                            {{-- Baris Jabatan | Divisi atau Komunitas --}}
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-1">
                                @if ($user->memberships && $user->memberships->isNotEmpty())
                                    @php $membership = $user->memberships->first(); @endphp
                                    <span class="text-brand-500 font-semibold">{{ $membership->role->name }}</span>
                                    <span class="mx-2 text-gray-300">|</span>
                                    <span class="text-gray-700 dark:text-gray-200">
                                        {{ $membership->unit->parent_id ? 'Divisi ' . $membership->unit->name : $membership->unit->name }}
                                    </span>
                                @else
                                    <span class="italic">Belum bergabung dalam organisasi</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- BAGIAN KANAN: TOMBOL GANTI FOTO & REMINDER --}}
                    <div class="flex flex-col items-start sm:items-end gap-2">
                        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <label
                                class="cursor-pointer inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition shadow-md">
                                <input type="file" name="photo" class="hidden" onchange="this.form.submit()">
                                <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 4.16663V15.8333" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M4.16663 10H15.8333" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                Ganti Foto
                            </label>
                        </form>

                        <div class="text-left sm:text-right">
                            <p class="text-[11px] text-gray-500 dark:text-gray-400">JPG, PNG (Maks 2MB)</p>
                            <p class="text-[10px] text-brand-500 italic">*Foto otomatis terupdate</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. KARTU INFORMASI PRIBADI --}}
            <div
                class="p-5 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6 bg-white dark:bg-gray-900 shadow-theme-xs">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div class="w-full">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">Informasi Pribadi</h4>
                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
                            <div>
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">Email Address</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">NPM</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->npm ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">Program Studi</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->prodi ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">Semester</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                    {{ $user->semester ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">No. Handphone</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->no_hp ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">Tanggal Lahir</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                    {{ $user->tanggal_lahir ? date('d F Y', strtotime($user->tanggal_lahir)) : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <button @click="editModalOpen = true"
                        class="flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 lg:inline-flex lg:w-auto shrink-0">
                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path
                                d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"
                                fill="currentColor" />
                        </svg>
                        Edit Profil
                    </button>
                </div>
            </div>

            {{-- 3. MODAL EDIT PROFIL --}}
            <div x-show="editModalOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
                style="display: none;">

                <div @click.outside="editModalOpen = false"
                    class="no-scrollbar relative w-full max-w-[750px] overflow-y-auto rounded-3xl bg-white p-6 dark:bg-gray-900 shadow-2xl max-h-[90vh] lg:p-11">

                    <div class="px-2 pr-14 mb-8">
                        <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">Edit Informasi</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui detail profil Anda di bawah ini.</p>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="px-2 overflow-y-auto custom-scrollbar">
                            <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">

                                {{-- Nama Lengkap --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                                        Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2 text-sm focus:border-brand-500 dark:border-gray-700 dark:text-white">
                                </div>

                                {{-- Email (Readonly) --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-500">Email
                                        Address (Tidak bisa diubah)</label>
                                    <input type="email" value="{{ $user->email }}" readonly
                                        class="h-11 w-full rounded-lg border border-gray-200 bg-gray-100 px-4 py-2 text-sm text-gray-500 cursor-not-allowed dark:border-gray-800 dark:bg-gray-800/50">
                                </div>

                                {{-- NPM --}}
                                <div>
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">NPM</label>
                                    <input type="text" name="npm" value="{{ old('npm', $user->npm) }}"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2 text-sm dark:border-gray-700 dark:text-white">
                                </div>

                                {{-- No Handphone --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">No.
                                        Handphone</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2 text-sm dark:border-gray-700 dark:text-white">
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div>
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal
                                        Lahir</label>
                                    <input type="date" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2 text-sm dark:border-gray-700 dark:text-white">
                                </div>

                                {{-- Program Studi (Select) --}}
                                <div>
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Program
                                        Studi</label>
                                    <select name="prodi"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2 text-sm dark:border-gray-700 dark:text-white">
                                        <option value="">-- Pilih Prodi --</option>
                                        @foreach (['TI', 'RPL', 'RSK', 'ILKOM'] as $p)
                                            <option value="{{ $p }}"
                                                {{ old('prodi', $user->prodi) == $p ? 'selected' : '' }}>
                                                {{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Semester (Select) --}}
                                <div class="lg:col-span-2">
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Semester</label>
                                    <select name="semester"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2 text-sm dark:border-gray-700 dark:text-white">
                                        <option value="">-- Pilih Semester --</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}"
                                                {{ old('semester', $user->semester) == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-8 lg:justify-end">
                            <button @click="editModalOpen = false" type="button"
                                class="flex w-full justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 sm:w-auto">Batal</button>
                            <button type="submit"
                                class="flex w-full justify-center rounded-lg bg-brand-500 px-8 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endsection
