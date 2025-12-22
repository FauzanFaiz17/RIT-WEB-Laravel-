@extends('layouts.app')

@section('content')
    {{-- Layout wrapper agar responsif dan tidak tertutup sidebar --}}
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        {{-- BREADCRUMB & JUDUL --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Edit Anggota
            </h2>
            <nav>
                <ol class="flex items-center gap-2 text-sm font-medium">
                    <li><a class="hover:text-primary" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li class="text-primary">Edit</li>
                </ol>
            </nav>
        </div>

        {{-- ALERT PESAN EROR (Penting untuk melihat kenapa gagal simpan) --}}
        @if ($errors->any())
            <div
                class="mb-6 flex w-full border-l-6 border-[#F87171] bg-[#F87171]/[0.05] p-4 shadow-md dark:bg-[#1b1b24] md:p-5">
                <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#F87171]">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.4917 7.65547L6.4917 7.65601L6.4917 7.65547ZM6.49035 1.22266C3.58265 1.22266 1.22266 3.58265 1.22266 6.49035C1.22266 9.39805 3.58265 11.758 6.49035 11.758C9.39805 11.758 11.758 9.39805 11.758 6.49035C11.758 3.58265 9.39805 1.22266 6.49035 1.22266ZM6.49035 10.8434C4.08835 10.8434 2.13735 8.89235 2.13735 6.49035C2.13735 4.08835 4.08835 2.13735 6.49035 2.13735C8.89235 2.13735 10.8434 4.08835 10.8434 6.49035C10.8434 8.89235 8.89235 10.8434 6.49035 10.8434Z"
                            fill="white" stroke="white" stroke-width="1.2"></path>
                    </svg>
                </div>
                <div class="w-full">
                    <h5 class="mb-1 text-lg font-semibold text-[#B45454]">Gagal Menyimpan Data</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-sm text-[#D17171]">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white shadow-default dark:border-gray-800 dark:bg-gray-900">
            <form action="{{ route('community_user.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- HIDDEN INPUT UNTUK UNIT_ID --}}
                {{-- Ini kunci agar unit_id selalu terkirim meskipun dropdown divisi dimatikan --}}
                <input type="hidden" name="unit_id" id="final_unit_id" value="{{ $member->unit_id }}">

                <div class="p-6.5">
                    {{-- NAMA USER --}}
                    <div class="mb-5">
                        <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Nama User </label>
                        <input type="text" value="{{ $member->user->name }} ({{ $member->user->email }})" readonly
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-500 cursor-not-allowed dark:border-gray-700 dark:bg-gray-800">
                    </div>

                    <div class="mb-5 flex flex-col gap-6 xl:flex-row">
                        {{-- DROPDOWN KOMUNITAS --}}
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Komunitas</label>
                            <div class="relative z-20">
                                <select id="communitySelect"
                                    class="relative z-20 w-full appearance-none rounded border border-stroke bg-white py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-gray-700 dark:bg-[#1d2a3a] !text-black dark:!text-white">
                                    <option value="" class="bg-white text-black dark:bg-[#1d2a3a] dark:text-white">--
                                        Pilih Komunitas --</option>
                                    @foreach ($communities as $community)
                                        <option value="{{ $community->id }}"
                                            class="bg-white text-black dark:bg-[#1d2a3a] dark:text-white"
                                            data-name="{{ strtolower($community->name) }}"
                                            {{ $member->unit->parent_id == $community->id || $member->unit_id == $community->id ? 'selected' : '' }}>
                                            {{ $community->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2"><svg class="fill-current"
                                        width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M7 10L12 15L17 10H7Z" fill="currentColor" />
                                    </svg></span>
                            </div>
                        </div>

                        {{-- DROPDOWN DIVISI --}}
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Divisi</label>
                            <div class="relative z-20">
                                <select id="divisionSelect"
                                    class="relative z-20 w-full appearance-none rounded border border-stroke bg-white py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-gray-700 dark:bg-[#1d2a3a] !text-black dark:!text-white disabled:bg-gray-200">
                                    <option value="" class="bg-white text-black dark:bg-[#1d2a3a] dark:text-white">--
                                        Tanpa Divisi --</option>
                                    @foreach ($divisions as $div)
                                        <option value="{{ $div->id }}"
                                            class="bg-white text-black dark:bg-[#1d2a3a] dark:text-white"
                                            {{ $member->unit_id == $div->id ? 'selected' : '' }}>
                                            {{ $div->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2"><svg class="fill-current"
                                        width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M7 10L12 15L17 10H7Z" fill="currentColor" />
                                    </svg></span>
                            </div>
                        </div>
                    </div>

                    {{-- ROLE --}}
                    <div class="mb-6">
                        <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Role / Jabatan</label>
                        <div class="relative z-20">
                            <select name="role_id" required
                                class="relative z-20 w-full appearance-none rounded border border-stroke bg-white py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-gray-700 dark:bg-[#1d2a3a] !text-black dark:!text-white">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        class="bg-white text-black dark:bg-[#1d2a3a] dark:text-white"
                                        {{ $member->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2"><svg class="fill-current"
                                    width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M7 10L12 15L17 10H7Z" fill="currentColor" />
                                </svg></span>
                        </div>
                    </div>
                    {{-- ACTION BUTTONS --}}
                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('member.list', $member->unit->name) }}"
                            class="flex w-1/2 justify-center rounded-lg border border-gray-300 py-3 font-medium text-black hover:bg-gray-50 dark:border-gray-700 dark:text-white transition shadow-theme-xs">
                            Kembali
                        </a>

                        <button type="submit"
                            class="flex w-1/2 justify-center rounded-lg bg-[#3C50E0] py-3 font-medium text-white hover:bg-opacity-90 transition shadow-md !bg-[#3C50E0]">
                            Simpan Perubahan
                        </button>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const commSelect = document.getElementById('communitySelect');
                            const divSelect = document.getElementById('divisionSelect');
                            const finalUnitId = document.getElementById('final_unit_id');

                            function updateUnitId() {
                                // Jika divisi dipilih, gunakan ID divisi. Jika tidak, gunakan ID komunitas.
                                if (divSelect.value && !divSelect.disabled) {
                                    finalUnitId.value = divSelect.value;
                                } else {
                                    finalUnitId.value = commSelect.value;
                                }
                            }

                            function checkCommunity() {
                                const selectedOpt = commSelect.options[commSelect.selectedIndex];
                                const name = selectedOpt.getAttribute('data-name');

                                if (name && name.includes('game')) {
                                    divSelect.value = "";
                                    divSelect.disabled = true;
                                    divSelect.classList.add('opacity-50');
                                } else {
                                    divSelect.disabled = false;
                                    divSelect.classList.remove('opacity-50');
                                }
                                updateUnitId();
                            }

                            commSelect.addEventListener('change', checkCommunity);
                            divSelect.addEventListener('change', updateUnitId);
                            checkCommunity(); // Jalankan saat load
                        });
                    </script>
                @endsection
