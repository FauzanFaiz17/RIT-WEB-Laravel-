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
        }
    }">
        <x-common.page-breadcrumb pageTitle="Arsip Surat" />

        <div class="space-y-6">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                    <span class="font-medium">Success!</span> {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <span class="font-medium">Error!</span> Please check the form inputs.
                </div>
            @endif

            <!-- Main Card -->
            <x-common.component-card title="Daftar Surat Masuk & Keluar">
                <div class="mb-4 text-right">
                    <button @click="showAddModal = true" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-3 text-center font-medium text-white hover:bg-brand-600 lg:px-6">
                        <span>
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 4.16666V15.8333" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4.16669 10H15.8334" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        Arsipkan Surat
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="max-w-full overflow-x-auto custom-scrollbar">
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
                                        <td class="px-5 py-4 sm:px-6 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                @if($surat->buktis->count() > 0)
                                                    <a href="{{ Storage::url($surat->buktis->first()->file_path) }}" target="_blank" class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </a>
                                                @endif
                                                
                                                <button @click="openEdit({{ json_encode($surat) }})" class="text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-blue-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 00-2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
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
            </x-common.component-card>
        </div>

        <!-- Add Surat Modal -->
        <div x-show="showAddModal" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5 backdrop-blur-[5px] bg-black/30">
            <div @click.outside="showAddModal = false" class="relative w-full max-w-lg rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Arsipkan Surat Baru</h3>
                    <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nomor Surat</label>
                                <input type="text" name="nomor_surat" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Surat</label>
                                <input type="date" name="tanggal" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
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

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Asal / Tujuan</label>
                            <input type="text" name="asal_tujuan" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" placeholder="Kepada Siapa / Dari Siapa">
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Ringkasan (Opsional)</label>
                            <textarea name="ringkasan" rows="2" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"></textarea>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Upload File / Scan</label>
                            <input type="file" name="file_surat[]" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        </div>

                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Surat Modal -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5 backdrop-blur-[5px] bg-black/30">
            <div @click.outside="showEditModal = false" class="relative w-full max-w-lg rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-2xl">
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
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nomor Surat</label>
                                <input type="text" name="nomor_surat" x-model="editNomor" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Surat</label>
                                <input type="date" name="tanggal" x-model="editTanggal" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
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

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Asal / Tujuan</label>
                            <input type="text" name="asal_tujuan" x-model="editAsal" required class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Ringkasan (Opsional)</label>
                            <textarea name="ringkasan" x-model="editRingkasan" rows="2" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"></textarea>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Upload Tambahan (Opsional)</label>
                            <input type="file" name="file_surat[]" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        </div>

                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
