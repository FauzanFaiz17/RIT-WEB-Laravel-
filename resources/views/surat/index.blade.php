@extends('layouts.app')

@section('content')
    <div x-data="{ 
        showAddModal: false,
        showEditModal: false,
        editId: null,
        editNomor: '',
        editTipe: 1,
        editPerihal: '',
        editAsal: '',
        editTanggal: '',
        editRingkasan: '',
        openEdit(surat) {
            this.editId = surat.id;
            this.editNomor = surat.nomor_surat;
            this.editTipe = surat.tipe_surat;
            this.editPerihal = surat.perihal;
            this.editAsal = surat.asal_tujuan;
            this.editTanggal = surat.tanggal;
            this.editRingkasan = surat.ringkasan;
            this.showEditModal = true;
            // Initialize flatpickr after modal opens
            setTimeout(() => {
                 const fp = document.querySelector('#edit-tanggal-input')._flatpickr;
                 if(fp && surat.tanggal) fp.setDate(surat.tanggal);
            }, 50);
        }
    }">
        <div class="flex flex-wrap items-center justify-end gap-3 mb-6">
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ url('/') }}">
                            Dashboard
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">
                        Arsip Surat
                    </li>
                </ol>
            </nav>
        </div>

        <div class="space-y-6">

            <!-- Main Card -->
            <x-common.component-card title="Daftar Surat Masuk & Keluar">
                <x-slot:action>
                    <button @click="showAddModal = true" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-3 text-center font-medium text-white hover:bg-brand-600 lg:px-6">
                        <span>
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 4.16666V15.8333" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4.16669 10H15.8334" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        Arsipkan Surat
                    </button>
                </x-slot:action>

                <!-- Filter Section -->
                <div class="mb-6 p-4 rounded-lg border border-gray-200 bg-gray-50/50 dark:border-gray-800 dark:bg-white/[0.03]">
                     <form action="{{ route('surat.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        <!-- Tipe -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tipe Surat</label>
                            <select name="tipe_surat" class="h-10 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 focus:ring-3 focus:outline-hidden focus:border-brand-300 focus:ring-brand-500/10 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500 dark:focus:border-brand-800">
                                <option value="">Semua</option>
                                <option value="1" {{ request('tipe_surat') == '1' ? 'selected' : '' }}>Surat Masuk</option>
                                <option value="2" {{ request('tipe_surat') == '2' ? 'selected' : '' }}>Surat Keluar</option>
                            </select>
                        </div>
                         <!-- Nomor -->
                         <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nomor Surat</label>
                            <input type="text" name="nomor_surat" value="{{ request('nomor_surat') }}" placeholder="Cari nomor..."
                                class="h-10 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 focus:ring-3 focus:outline-hidden focus:border-brand-300 focus:ring-brand-500/10 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500 dark:focus:border-brand-800">
                        </div>
                        <!-- Perihal -->
                         <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Perihal</label>
                            <input type="text" name="perihal" value="{{ request('perihal') }}" placeholder="Cari perihal..."
                                class="h-10 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 focus:ring-3 focus:outline-hidden focus:border-brand-300 focus:ring-brand-500/10 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500 dark:focus:border-brand-800">
                        </div>
                         <!-- Asal / Tujuan -->
                         <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Asal / Tujuan</label>
                            <input type="text" name="asal_tujuan" value="{{ request('asal_tujuan') }}" placeholder="Cari asal/tujuan..."
                                class="h-10 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 focus:ring-3 focus:outline-hidden focus:border-brand-300 focus:ring-brand-500/10 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500 dark:focus:border-brand-800">
                        </div>

                        <!-- Actions -->
                        <div class="sm:col-span-2 lg:col-span-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 dark:bg-white/10 dark:hover:bg-white/20 dark:focus:ring-white">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="max-w-full overflow-x-auto custom-scrollbar pb-40">
                        <table class="w-full min-w-[800px]">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Tipe</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nomor & Tanggal</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Perihal</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Asal / Tujuan</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Bukti</p>
                                    </th>
                                    <th class="px-5 py-3 text-right sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aksi</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surats as $surat)
                                    <tr class="border-b border-gray-100 dark:border-gray-800">
                                        <td class="px-5 py-4 sm:px-6">
                                            @if($surat->tipe_surat == 1)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                    Masuk
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100">
                                                    Keluar
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <div class="flex flex-col">
                                                <span class="font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $surat->nomor_surat }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($surat->tanggal)->format('d M Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400 truncate max-w-xs" title="{{ $surat->perihal }}">
                                                {{ $surat->perihal }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                {{ $surat->asal_tujuan }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            @if($surat->buktis->count() > 0)
                                                <div x-data="{ showFiles: false }" class="relative">
                                                    @if($surat->buktis->count() === 1)
                                                        <a href="{{ Storage::url($surat->buktis->first()->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-brand-500 hover:text-brand-600 dark:text-brand-400 dark:hover:text-brand-300">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                            <span class="text-xs font-medium">Lihat</span>
                                                        </a>
                                                    @else
                                                        <button @click="showFiles = !showFiles" class="inline-flex items-center gap-1.5 text-brand-500 hover:text-brand-600 dark:text-brand-400 dark:hover:text-brand-300">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                            <span class="text-xs font-medium">{{ $surat->buktis->count() }} File</span>
                                                        </button>
                                                        <!-- Dropdown Files -->
                                                        <div x-show="showFiles" @click.outside="showFiles = false" class="absolute left-0 z-10 mt-1 w-48 rounded-md border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                                                            <div class="py-1">
                                                                @foreach($surat->buktis as $index => $bukti)
                                                                    <a href="{{ Storage::url($bukti->file_path) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                                                        Bukti {{ $index + 1 }}
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 sm:px-6 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button @click="openEdit({{ json_encode($surat) }})" class="text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-blue-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>
                                                <form action="{{ route('surat.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Yakin hapus surat ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Belum ada arsip surat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                 <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                    {{ $surats->links() }}
                </div>
            </x-common.component-card>
        </div>

        <!-- Add Surat Modal -->
        <div x-show="showAddModal" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5 backdrop-blur-[2px] bg-black/50">
            <div @click.outside="showAddModal = false" class="relative w-full max-w-4xl rounded-3xl bg-white dark:bg-gray-900 p-8 shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Arsipkan Surat Baru</h3>
                    <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nomor Surat</label>
                                <input type="text" name="nomor_surat" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Surat</label>
                                <div class="relative">
                                    <input type="text" name="tanggal" required class="datepicker dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent pl-10 pr-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" placeholder="Pilih Tanggal">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tipe Surat</label>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="tipe_surat" value="1" checked class="w-4 h-4 text-brand-500 bg-gray-100 border-gray-300 focus:ring-brand-500 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Surat Masuk</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="tipe_surat" value="2" class="w-4 h-4 text-brand-500 bg-gray-100 border-gray-300 focus:ring-brand-500 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Surat Keluar</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Perihal</label>
                                <input type="text" name="perihal" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Asal / Tujuan</label>
                                <input type="text" name="asal_tujuan" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" placeholder="Kepada Siapa / Dari Siapa">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Ringkasan (Opsional)</label>
                                <textarea name="ringkasan" rows="3" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"></textarea>
                            </div>
                             <!-- File Upload UI -->
                            <div x-data="{ fileName: '' }">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Upload File / Scan</label>
                                <div class="relative">
                                    <input type="file" name="file_surat[]" multiple @change="fileName = $event.target.files.length > 0 ? $event.target.files.length + ' File Siap Diupload' : ''" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="flex items-center justify-between w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-900 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">
                                        <span x-text="fileName ? fileName : 'Pilih file (PDF / Gambar)...'"></span>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    </div>
                                    <p x-show="fileName" class="mt-1 text-xs text-green-600 dark:text-green-400">File siap diupload</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3 mt-8">
                        <button type="button" @click="showAddModal = false" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700">Batal</button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Surat Modal -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5 backdrop-blur-[2px] bg-black/50">
            <div @click.outside="showEditModal = false" class="relative w-full max-w-4xl rounded-3xl bg-white dark:bg-gray-900 p-8 shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Edit Arsip Surat</h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <!-- Action ID dynamically passed -->
                <form :action="`{{ route('surat.index') }}/${editId}`" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nomor Surat</label>
                                <input type="text" name="nomor_surat" x-model="editNomor" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Surat</label>
                                <div class="relative">
                                    <input type="text" id="edit-tanggal-input" name="tanggal" x-model="editTanggal" required class="datepicker dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tipe Surat</label>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="tipe_surat" value="1" x-model="editTipe" class="w-4 h-4 text-brand-500 bg-gray-100 border-gray-300 focus:ring-brand-500 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Surat Masuk</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="tipe_surat" value="2" x-model="editTipe" class="w-4 h-4 text-brand-500 bg-gray-100 border-gray-300 focus:ring-brand-500 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Surat Keluar</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Perihal</label>
                                <input type="text" name="perihal" x-model="editPerihal" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            </div>
                        </div>

                         <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Asal / Tujuan</label>
                                <input type="text" name="asal_tujuan" x-model="editAsal" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Ringkasan (Opsional)</label>
                                <textarea name="ringkasan" x-model="editRingkasan" rows="3" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"></textarea>
                            </div>

                            <!-- File Upload UI -->
                            <div x-data="{ fileName: '' }">
                                 <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Upload Tambahan (Opsional)</label>
                                <div class="relative">
                                    <input type="file" name="file_surat[]" multiple @change="fileName = $event.target.files.length > 0 ? $event.target.files.length + ' File Siap Diupload' : ''" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="flex items-center justify-between w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-900 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">
                                        <span x-text="fileName ? fileName : 'Pilih file (PDF / Gambar) jika ada...'"></span>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    </div>
                                    <p x-show="fileName" class="mt-1 text-xs text-green-600 dark:text-green-400">File siap diupload</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8">
                        <button type="button" @click="showEditModal = false" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700">Batal</button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d", // Format untuk database
                altInput: true,
                altFormat: "d-m-Y",  // Format tampilan user
                allowInput: true,
                locale: "id"
            });
        });
    </script>
@endsection
