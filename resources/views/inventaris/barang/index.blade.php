
@extends('layouts.app')

@section('content')
    <div x-data="{ 
        showAddModal: {{ $errors->any() ? 'true' : 'false' }}, 
        showEditModal: false,
        editId: null,
        editNama: '',
        editJumlah: 0,
        editTerpakai: 0,
        openEdit(barang) {
            this.editId = barang.id;
            this.editNama = barang.nama_barang;
            // Calculate total based on stok + terpakai if needed, or use raw data
            // Based on controller, 'stok' is stored. 'jumlah' (total) is stok + terpakai.
            this.editJumlah = parseInt(barang.stok) + parseInt(barang.terpakai);
            this.editTerpakai = barang.terpakai;
            this.showEditModal = true;
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
                        Inventaris Barang
                    </li>
                </ol>
            </nav>
        </div>

        <div class="space-y-6">

            <!-- Main Card -->
            <x-common.component-card title="Daftar Barang">
                <x-slot:action>
                    <button @click="showAddModal = true" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-3 text-center font-medium text-white hover:bg-brand-600 lg:px-6">
                        <span>
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 4.16666V15.8333" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4.16669 10H15.8334" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        Tambah Barang
                    </button>
                </x-slot:action>

                <!-- Filter Section -->
                <div class="mb-6 p-4 rounded-lg border border-gray-200 bg-gray-50/50 dark:border-gray-800 dark:bg-white/[0.03]">
                     <form action="{{ route('inventaris.barang.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        <!-- Nama Barang -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Barang</label>
                            <input type="text" name="nama_barang" value="{{ request('nama_barang') }}" placeholder="Cari nama barang..."
                                class="h-10 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 focus:ring-3 focus:outline-hidden focus:border-brand-300 focus:ring-brand-500/10 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500 dark:focus:border-brand-800">
                        </div>
                         <!-- Jumlah -->
                         <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jumlah (Total)</label>
                            <input type="number" name="jumlah" value="{{ request('jumlah') }}" placeholder="Cari jumlah..."
                                class="h-10 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 focus:ring-3 focus:outline-hidden focus:border-brand-300 focus:ring-brand-500/10 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500 dark:focus:border-brand-800">
                        </div>
                        <!-- Dipakai -->
                         <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Dipakai</label>
                            <input type="number" name="terpakai" value="{{ request('terpakai') }}" placeholder="Cari jumlah dipakai..."
                                class="h-10 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 focus:ring-3 focus:outline-hidden focus:border-brand-300 focus:ring-brand-500/10 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500 dark:focus:border-brand-800">
                        </div>
                         <!-- Stok -->
                         <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Stok Tersedia</label>
                            <input type="number" name="stok" value="{{ request('stok') }}" placeholder="Cari stok..."
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
                        <table class="w-full min-w-[600px]">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama Barang</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Jumlah</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Dipakai</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Stok Tersedia</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Last Updated</p>
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
                                @forelse($barangs as $barang)
                                    <tr class="border-b border-gray-100 dark:border-gray-800">
                                        <td class="px-5 py-4 sm:px-6">
                                            <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $barang->nama_barang }}</span>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <span class="text-gray-700 dark:text-gray-300">{{ $barang->stok + $barang->terpakai }}</span>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <span class="text-gray-700 dark:text-gray-300">{{ $barang->terpakai }}</span>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $barang->stok > 0 ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                                {{ $barang->stok }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $barang->updated_at->format('d M Y') }}</p>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            @if($barang->buktis->count() > 0)
                                                <div x-data="{ showFiles: false }" class="relative">
                                                    @if($barang->buktis->count() === 1)
                                                        <a href="{{ Storage::url($barang->buktis->first()->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-brand-500 hover:text-brand-600 dark:text-brand-400 dark:hover:text-brand-300">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                            <span class="text-xs font-medium">Lihat</span>
                                                        </a>
                                                    @else
                                                        <button @click="showFiles = !showFiles" class="inline-flex items-center gap-1.5 text-brand-500 hover:text-brand-600 dark:text-brand-400 dark:hover:text-brand-300">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                            <span class="text-xs font-medium">{{ $barang->buktis->count() }} File</span>
                                                        </button>
                                                        <!-- Dropdown Files -->
                                                        <div x-show="showFiles" @click.outside="showFiles = false" class="absolute left-0 z-10 mt-1 w-48 rounded-md border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                                                            <div class="py-1">
                                                                @foreach($barang->buktis as $index => $bukti)
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
                                                <button 
                                                    @click="openEdit({{ json_encode($barang) }})"
                                                    class="text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-blue-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>
                                                <form action="{{ route('inventaris.barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Belum ada data barang.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                    {{ $barangs->links() }}
                </div>
            </x-common.component-card>
        </div>

        <!-- Add Barang Modal -->
        <div x-show="showAddModal" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5 backdrop-blur-[2px] bg-black/50">
            <div @click.outside="showAddModal = false" class="relative w-full max-w-lg rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Tambah Barang Baru</h3>
                    <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('inventaris.barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Barang</label>
                            <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" required class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:border-gray-700 dark:text-white shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800" placeholder="Contoh: Laptop Acer">
                            @error('nama_barang') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jumlah Barang (Total)</label>
                                <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" required class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:border-gray-700 dark:text-white shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800">
                                @error('jumlah') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Dipakai (Rusak/Dipinjam)</label>
                                <input type="number" name="terpakai" value="{{ old('terpakai', 0) }}" min="0" required class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:border-gray-700 dark:text-white shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800">
                                @error('terpakai') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <!-- File Upload UI -->
                        <div x-data="{ fileName: '' }">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Bukti Barang (Gambar)</label>
                            @error('bukti.*') <span class="text-xs text-red-500 block mb-1">{{ $message }}</span> @enderror
                            <div class="relative">
                                <input type="file" name="bukti[]" multiple accept="image/*" @change="fileName = $event.target.files.length > 0 ? $event.target.files.length + ' File Siap Diupload' : ''" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="flex items-center justify-between w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-900 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">
                                    <span x-text="fileName ? fileName : 'Pilih gambar...'"></span>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <p x-show="fileName" class="mt-1 text-xs text-green-600 dark:text-green-400">File siap diupload</p>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Barang Modal -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5 backdrop-blur-[2px] bg-black/50">
            <div @click.outside="showEditModal = false" class="relative w-full max-w-lg rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Edit Barang</h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form :action="`{{ route('inventaris.barang.store') }}/${editId}`" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Barang</label>
                            <input type="text" name="nama_barang" x-model="editNama" required class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:border-gray-700 dark:text-white shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jumlah Barang (Total)</label>
                                <input type="number" name="jumlah" x-model="editJumlah" min="1" required class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:border-gray-700 dark:text-white shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Dipakai (Rusak/Dipinjam)</label>
                                <input type="number" name="terpakai" x-model="editTerpakai" min="0" required class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:border-gray-700 dark:text-white shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800">
                            </div>
                        </div>
                        
                        <!-- File Upload UI -->
                        <div x-data="{ fileName: '' }">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Upload Bukti Baru (Opsional)</label>
                            <div class="relative">
                                <input type="file" name="bukti[]" multiple accept="image/*" @change="fileName = $event.target.files.length > 0 ? $event.target.files.length + ' File Siap Diupload' : ''" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="flex items-center justify-between w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-900 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">
                                    <span x-text="fileName ? fileName : 'Pilih gambar jika ingin mengganti...'"></span>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <p x-show="fileName" class="mt-1 text-xs text-green-600 dark:text-green-400">File siap diupload</p>
                            </div>
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
