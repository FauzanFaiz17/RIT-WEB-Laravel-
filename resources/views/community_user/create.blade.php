@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-md p-4 md:p-6 2xl:p-10">

        {{-- HEADER --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Tambah Anggota Baru
                </h2>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Masukkan mahasiswa ke dalam Komunitas atau Divisi tertentu.
                </p>
            </div>
        </div>



        {{-- CARD FORM --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">

            <form action="{{ route('community_user.store') }}" method="POST">
                @csrf

                <div class="space-y-6">

                    {{-- 1. PILIH USER --}}
                    <div>
                        <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">
                            Pilih User (Mahasiswa) <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative z-20">
                            <select name="user_id" required
                                class="relative z-20 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-none transition focus:border-primary active:border-primary dark:border-gray-700 dark:bg-form-input !text-black dark:!text-white">
                                <option value="" disabled selected>-- Cari Nama Mahasiswa --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M7 10L12 15L17 10H7Z" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    {{-- 2. PENEMPATAN UNIT (LOGIKA OTOMATIS / MANUAL) --}}
                    <div>
                        <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">
                            Penempatan (Unit) <span class="text-meta-1">*</span>
                        </label>

                        @if (isset($selectedUnit))
                            {{-- MODE TERKUNCI: Jika diakses dari list anggota komunitas/divisi spesifik --}}
                            <input type="hidden" name="unit_id" value="{{ $selectedUnit->id }}">

                            <div class="relative">
                                <input type="text" readonly
                                    value="{{ $selectedUnit->parent ? $selectedUnit->parent->name . ' - ' . $selectedUnit->name : $selectedUnit->name }}"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3 text-sm text-gray-500 cursor-not-allowed dark:border-gray-700 dark:bg-gray-800 shadow-inner">
                                <span class="absolute top-1/2 right-4 -translate-y-1/2">
                                    <svg class="text-gray-400" width="18" height="18" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                            
                        @else
                            {{-- MODE MANUAL: Jika diakses dari menu navigasi umum --}}
                            <div class="relative z-20">
                                <select name="unit_id" required
                                    class="relative z-20 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-none transition focus:border-primary active:border-primary dark:border-gray-700 dark:bg-form-input !text-black dark:!text-white">
                                    <option value="" disabled selected>-- Pilih Komunitas / Divisi --</option>
                                    @foreach ($communities as $community)
                                        <optgroup label="{{ $community->name }}">
                                            <option value="{{ $community->id }}">↳ {{ $community->name }} </option>
                                            @foreach ($community->children as $division)
                                                <option value="{{ $division->id }}">&nbsp;&nbsp;&nbsp;&nbsp;•
                                                    {{ $division->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path d="M7 10L12 15L17 10H7Z" fill="currentColor" />
                                    </svg>
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- 3. PILIH JABATAN (ROLE) --}}
                    <div>
                        <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">
                            Jabatan <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative z-20">
                            <select name="role_id" required
                                class="relative z-20 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-none transition focus:border-primary active:border-primary dark:border-gray-700 dark:bg-form-input !text-black dark:!text-white">
                                <option value="" disabled selected>-- Pilih Jabatan --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M7 10L12 15L17 10H7Z" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>

                </div>

                {{-- TOMBOL AKSI --}}
                <div class="mt-10 flex items-center justify-end gap-4">
                    {{-- Perbaikan: Jika ada unit terpilih, kembali ke list anggota unit tersebut. Jika tidak, kembali ke dashboard --}}
                    <a href="{{ isset($selectedUnit) ? route('member.list', $selectedUnit->name) : route('dashboard') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-8 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 transition-all">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-[#3C50E0] px-8 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-opacity-90 transition-all !bg-[#3C50E0] !text-white">
                        Simpan Anggota
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
