@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-270"> 
    <!-- Breadcrumb -->
    <div class="flex flex-wrap items-center justify-end gap-3 mb-6">
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('dashboard') }}">
                        Dashboard
                        <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">
                    Keuangan
                </li>
            </ol>
        </nav>
    </div>

    <div class="space-y-6">


        <!-- Top Grid: Summary & Chart -->
        <div class="grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5 mb-6">
        
        <!-- Left: Summary Card (Total Saldo) -->
        <div class="col-span-12 xl:col-span-4 rounded-xl border border-gray-200 bg-white py-6 px-7.5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-4">
                <!-- Saldo -->
                <div class="flex items-center justify-between rounded-lg bg-gray-50 p-4 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-brand-500 text-white shadow-sm ring-4 ring-brand-50 dark:ring-white/5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Saldo</span>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                                Rp {{ number_format($saldo, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Pemasukan -->
                <div class="flex items-center justify-between rounded-lg bg-gray-50 p-4 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-500 text-white shadow-sm ring-4 ring-green-50 dark:ring-white/5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Pemasukan</span>
                            <h4 class="text-lg font-bold text-green-600 dark:text-green-400">
                                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- Pengeluaran -->
                <div class="flex items-center justify-between rounded-lg bg-gray-50 p-4 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-500 text-white shadow-sm ring-4 ring-red-50 dark:ring-white/5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Pengeluaran</span>
                            <h4 class="text-lg font-bold text-red-600 dark:text-red-400">
                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Chart -->
        <div class="col-span-12 xl:col-span-8 rounded-xl border border-gray-200 bg-white px-5 pt-7.5 pb-5 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5">
            <div class="mb-3 flex flex-wrap gap-3 justify-between sm:flex-nowrap">
                <div>
                    <h4 class="text-xl font-bold text-gray-800 dark:text-white">Statistik Keuangan</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Target yang telah ditetapkan untuk setiap periode</p>
                </div>
                <div class="flex flex-col items-end gap-3">
                    <!-- Tab Buttons Container -->
                    <div class="inline-flex rounded-lg bg-gray-100 p-1 dark:bg-gray-800">
                        <a href="{{ route('keuangan.index', array_merge(request()->all(), ['period' => 'harian'])) }}" 
                           class="px-3 py-1.5 text-sm font-medium rounded-md transition-all {{ ($periodType ?? 'harian') === 'harian' ? 'bg-white text-gray-900 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Harian
                        </a>
                        <a href="{{ route('keuangan.index', array_merge(request()->all(), ['period' => 'mingguan'])) }}" 
                           class="px-3 py-1.5 text-sm font-medium rounded-md transition-all {{ ($periodType ?? 'harian') === 'mingguan' ? 'bg-white text-gray-900 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Mingguan
                        </a>
                        <a href="{{ route('keuangan.index', array_merge(request()->all(), ['period' => 'bulanan'])) }}" 
                           class="px-3 py-1.5 text-sm font-medium rounded-md transition-all {{ ($periodType ?? 'harian') === 'bulanan' ? 'bg-white text-gray-900 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Bulanan
                        </a>
                    </div>
                    <!-- Legend -->
                    <div class="flex items-center gap-2">
                        <span class="inline-block h-3 w-3 rounded-full bg-green-500"></span>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Masuk</span>
                        <span class="ml-2 inline-block h-3 w-3 rounded-full bg-red-500"></span>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Keluar</span>
                    </div>
                </div>
            </div>
            
            <div id="chartKeuangan" class="-ml-5"></div>
        </div>
    </div>

    <!-- Action Button (Prominent) -->
    <div class="mb-6 flex justify-end gap-4">
        <button @click="$dispatch('open-modal', 'add-transaction-modal')" 
            class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-3 text-center font-medium text-white hover:bg-brand-600 lg:px-6">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 5V15M5 10H15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Tambah Transaksi Baru
        </button>
    </div>

    <!-- Transaction History Card -->
    <x-common.component-card title="Riwayat Transaksi">
        <!-- Filter Section -->
        <div class="mb-6 p-4 rounded-lg border border-gray-200 bg-gray-50/50 dark:border-gray-800 dark:bg-white/[0.03]">
             <form action="{{ route('keuangan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                <!-- Start Date -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Dari Tanggal</label>
                    <div class="relative">
                        <input type="date" name="start_date" value="{{ request('start_date') }}" 
                            class="datepicker dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500 dark:text-gray-400">
                           <svg class="fill-current w-4 h-4" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                               <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6667 2.5H15V1.66667C15 1.20643 14.6269 0.833333 14.1667 0.833333C13.7064 0.833333 13.3333 1.20643 13.3333 1.66667V2.5H6.66667V1.66667C6.66667 1.20643 6.29357 0.833333 5.83333 0.833333C5.3731 0.833333 5 1.20643 5 1.66667V2.5H3.33333C2.41286 2.5 1.66667 3.24619 1.66667 4.16667V15.8333C1.66667 16.7538 2.41286 17.5 3.33333 17.5H16.6667C17.5871 17.5 18.3333 16.7538 18.3333 15.8333V4.16667C18.3333 3.24619 17.5871 2.5 16.6667 2.5ZM16.6667 5.83333H3.33333V4.16667H16.6667V5.83333ZM3.33333 7.5V15.8333H16.6667V7.5H3.33333Z" fill="currentColor"/>
                           </svg>
                        </span>
                    </div>
                </div>
                 <!-- End Date -->
                 <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Sampai Tanggal</label>
                    <div class="relative">
                        <input type="date" name="end_date" value="{{ request('end_date') }}" 
                            class="datepicker dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500 dark:text-gray-400">
                           <svg class="fill-current w-4 h-4" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                               <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6667 2.5H15V1.66667C15 1.20643 14.6269 0.833333 14.1667 0.833333C13.7064 0.833333 13.3333 1.20643 13.3333 1.66667V2.5H6.66667V1.66667C6.66667 1.20643 6.29357 0.833333 5.83333 0.833333C5.3731 0.833333 5 1.20643 5 1.66667V2.5H3.33333C2.41286 2.5 1.66667 3.24619 1.66667 4.16667V15.8333C1.66667 16.7538 2.41286 17.5 3.33333 17.5H16.6667C17.5871 17.5 18.3333 16.7538 18.3333 15.8333V4.16667C18.3333 3.24619 17.5871 2.5 16.6667 2.5ZM16.6667 5.83333H3.33333V4.16667H16.6667V5.83333ZM3.33333 7.5V15.8333H16.6667V7.5H3.33333Z" fill="currentColor"/>
                           </svg>
                        </span>
                    </div>
                </div>
                <!-- Type -->
                <div class="space-y-4">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jenis</label>
                        <div class="relative">
                            <select name="jenis" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                                <option value="">Semua</option>
                                <option value="1" {{ request('jenis') == '1' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="2" {{ request('jenis') == '2' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Kategori Filter -->
                <div>
                     <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kategori</label>
                     <div class="relative">
                         <select name="kategori_id" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                             <option value="">Semua Kategori</option>
                             @foreach($kategoris as $kategori)
                                 <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                     {{ $kategori->nama_kategori }}
                                 </option>
                             @endforeach
                         </select>
                     </div>
                 </div>
                <!-- Actions -->
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 dark:bg-white/10 dark:hover:bg-white/20 dark:focus:ring-white">
                    Terapkan Filter
                </button>
            </form>
        </div>

        <!-- Table Content -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Tanggal</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Jenis</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Kategori</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Keterangan</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nominal</p>
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
                        @foreach($keuangans as $keuangan)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ \Carbon\Carbon::parse($keuangan->tanggal)->translatedFormat('d M Y') }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    @if($keuangan->jenis == 1)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                            Masuk
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                            Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $keuangan->kategori->nama_kategori ?? '-' }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-gray-800 text-theme-sm dark:text-white/90">{{ $keuangan->uraian }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="font-medium text-theme-sm {{ $keuangan->jenis == 1 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $keuangan->jenis == 1 ? '+' : '-' }} Rp {{ number_format($keuangan->nominal, 0, ',', '.') }}
                                    </p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    @if($keuangan->buktis->count() > 0)
                                        <div x-data="{ showFiles: false }">
                                            @if($keuangan->buktis->count() === 1)
                                                <a href="{{ Storage::url($keuangan->buktis->first()->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-brand-500 hover:text-brand-600 dark:text-brand-400 dark:hover:text-brand-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    <span class="text-xs font-medium">Lihat</span>
                                                </a>
                                            @else
                                                <button @click="showFiles = !showFiles" class="inline-flex items-center gap-1.5 text-brand-500 hover:text-brand-600 dark:text-brand-400 dark:hover:text-brand-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                    <span class="text-xs font-medium">{{ $keuangan->buktis->count() }} File</span>
                                                </button>
                                                <!-- Dropdown Files -->
                                                <div x-show="showFiles" @click.outside="showFiles = false" class="absolute z-10 mt-1 w-48 rounded-md border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                                                    <div class="py-1">
                                                        @foreach($keuangan->buktis as $index => $bukti)
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
                                        <button @click="openEditModal({{ json_encode($keuangan) }})" class="text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-blue-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <form action="{{ route('keuangan.destroy', $keuangan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                {{ $keuangans->links() }}
            </div>
    </x-common.component-card>

<!-- Add Modal -->
<x-ui.modal name="add-transaction-modal" 
    class="w-full max-w-4xl p-8"
    :showCloseButton="false"
    x-on:open-modal.window="if ($event.detail === 'add-transaction-modal') open = true">
    
    <!-- Modal Header -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-gray-800 dark:text-white">
            Catat Transaksi Baru
        </h3>
        <button @click="open = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Modal Form -->
    <form action="{{ route('keuangan.store') }}" method="POST" enctype="multipart/form-data" 
          x-data="{ 
              jenis: '1', 
              categoryType: 'existing',
              files: [],
              handleFileChange(event) {
                  this.files = Array.from(event.target.files);
              },
              toggleNewCategory() { this.categoryType = 'new'; },
              toggleExistingCategory() { this.categoryType = 'existing'; },
              formatRupiah(event) {
                 let value = event.target.value.replace(/[^0-9]/g, '');
                 if (value) {
                     value = parseInt(value, 10).toLocaleString('id-ID');
                 }
                 event.target.value = value.replace(/,/g, '.'); // Ensure dot separation
              }
          }">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-5">
                <!-- 1. Jenis Transaksi -->
                <div>
                     <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Jenis Transaksi</label>
                     <div class="flex gap-4">
                        <label class="relative flex-1 cursor-pointer">
                            <input type="radio" name="jenis" value="1" class="peer sr-only" x-model="jenis">
                            <div class="flex h-12 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 transition-all hover:bg-gray-50 peer-checked:border-brand-500 peer-checked:text-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:peer-checked:border-brand-400 dark:peer-checked:text-brand-400">
                                <span class="font-medium">Pemasukan</span>
                            </div>
                        </label>
                        <label class="relative flex-1 cursor-pointer">
                            <input type="radio" name="jenis" value="2" class="peer sr-only" x-model="jenis">
                            <div class="flex h-12 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 transition-all hover:bg-gray-50 peer-checked:border-brand-500 peer-checked:text-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:peer-checked:border-brand-400 dark:peer-checked:text-brand-400">
                                <span class="font-medium">Pengeluaran</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 2. Kategori -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Kategori</label>
                    <div x-show="categoryType === 'existing'" class="relative">
                        <select name="kategori_keuangan_id" :x-show="categoryType !== 'existing'" 
                            class="h-12 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 shadow-theme-xs appearance-none">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 7.5L10 12.5L15 7.5" stroke="#64748B" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                    </div>
                    <div x-show="categoryType === 'new'" class="flex gap-2">
                        <input type="hidden" name="kategori_keuangan_id" value="new" :disabled="categoryType !== 'new'">
                        <input type="text" name="new_category_name" placeholder="Nama Kategori Baru" :disabled="categoryType !== 'new'"
                            class="h-12 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 shadow-theme-xs">
                    </div>
                    <div class="mt-1 flex justify-end">
                        <button type="button" class="text-xs text-brand-500 hover:text-brand-600 hover:underline" x-show="categoryType === 'existing'" @click="toggleNewCategory()">+ Buat Kategori Baru</button>
                        <button type="button" class="text-xs text-brand-500 hover:text-brand-600 hover:underline" x-show="categoryType === 'new'" @click="toggleExistingCategory()">Pilih Existing</button>
                    </div>
                </div>

                <!-- 3. Nominal -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Nominal (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">Rp</span>
                        <input type="text" name="nominal" required x-on:input="formatRupiah($event)" placeholder="0"
                            class="h-12 w-full rounded-lg border border-gray-300 bg-white pl-10 pr-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 shadow-theme-xs">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-5">
                <!-- 4. Uraian / Keterangan -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Keterangan</label>
                    <textarea name="uraian" rows="3"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 shadow-theme-xs"></textarea>
                </div>

                <!-- 5. Tanggal -->
                <!-- 5. Tanggal -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500 dark:text-gray-400">
                           <svg class="fill-current w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                               <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6667 2.5H15V1.66667C15 1.20643 14.6269 0.833333 14.1667 0.833333C13.7064 0.833333 13.3333 1.20643 13.3333 1.66667V2.5H6.66667V1.66667C6.66667 1.20643 6.29357 0.833333 5.83333 0.833333C5.3731 0.833333 5 1.20643 5 1.66667V2.5H3.33333C2.41286 2.5 1.66667 3.24619 1.66667 4.16667V15.8333C1.66667 16.7538 2.41286 17.5 3.33333 17.5H16.6667C17.5871 17.5 18.3333 16.7538 18.3333 15.8333V4.16667C18.3333 3.24619 17.5871 2.5 16.6667 2.5ZM16.6667 5.83333H3.33333V4.16667H16.6667V5.83333ZM3.33333 7.5V15.8333H16.6667V7.5H3.33333Z" fill="currentColor"/>
                           </svg>
                        </span>
                        <input type="text" name="tanggal" required placeholder="DD-MM-YYYY"
                            class="datepicker h-12 w-full rounded-lg border border-gray-300 bg-white pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 shadow-theme-xs">
                    </div>
                </div>

                <!-- 6. Bukti -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Bukti (Struk/Nota)</label>
                    <div class="flex flex-col items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="files.length === 0">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">JPEG, PNG, JPG (Max. 2MB)</p>
                            </div>
                            <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="files.length > 0">
                                <svg class="w-8 h-8 mb-4 text-brand-500 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="mb-2 text-sm font-semibold text-gray-700 dark:text-white" x-text="files.length + ' File Siap Diupload'"></p>
                                <template x-for="file in files">
                                    <p class="text-xs text-gray-500 dark:text-gray-400" x-text="file.name"></p>
                                </template>
                            </div>
                            <input type="file" name="bukti_file[]" multiple class="hidden" @change="handleFileChange" />
                        </label>
                    </div>  
                </div>
            </div>
        </div>

        <!-- Footer Buttons -->
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700 mt-6">
            <button type="button" @click="open = false" 
                class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700 transition-colors">
                Batal
            </button>
            <button type="submit" 
                class="px-5 py-2.5 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 focus:outline-none focus:ring-4 focus:ring-brand-500/20 shadow-lg shadow-brand-500/10 transition-colors">
                Simpan Transaksi
            </button>
        </div>
    </form>
</x-ui.modal>

<!-- Edit Modal -->
<x-ui.modal name="edit-transaction-modal" 
    class="w-full max-w-4xl p-8"
    :showCloseButton="false"
    x-on:open-edit-modal.window="open = true; data = $event.detail">
    
    <!-- Modal Header -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-gray-800 dark:text-white">
            Edit Transaksi
        </h3>
        <button @click="open = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Modal Form -->
    <!-- Modal Form -->
    <form :action="'/keuangan/' + (data.id || '')" method="POST" enctype="multipart/form-data" 
          x-data="{ 
            data: {}, 
            files: [],
            handleFileChange(event) {
                  this.files = Array.from(event.target.files);
            },
            formatRupiah(event) {
                 let value = event.target.value.replace(/[^0-9]/g, '');
                 if (value) {
                     value = parseInt(value, 10).toLocaleString('id-ID');
                 }
                 event.target.value = value.replace(/,/g, '.');
                 this.data.nominal = event.target.value; // sync x-model
            }
          }" 
          x-on:open-edit-modal.window="
             data = $event.detail;
             // Format nominal on load
             if(data.nominal) {
                 data.nominal = parseInt(data.nominal, 10).toLocaleString('id-ID').replace(/,/g, '.');
             }
             files = []; // reset files
             // Sync flatpickr if needed (usually x-model handles it but flatpickr instance needs update)
             setTimeout(() => {
                const fp = document.querySelector('#edit-tanggal-input')._flatpickr;
                if(fp && data.tanggal) fp.setDate(data.tanggal);
             }, 50);
          ">
        @csrf @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-5">
                <!-- 1. Jenis Transaksi -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Jenis</label>
                    <div class="relative">
                        <select name="jenis" x-model="data.jenis" class="h-12 w-full rounded-lg border border-gray-300 bg-white pl-4 pr-10 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 shadow-theme-xs appearance-none">
                            <option value="1">Pemasukan</option>
                            <option value="2">Pengeluaran</option>
                        </select>
                         <span class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 7.5L10 12.5L15 7.5" stroke="#64748B" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                    </div>
                </div>

                <!-- 2. Kategori -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Kategori</label>
                    <div class="relative">
                        <select name="kategori_keuangan_id" x-model="data.kategori_keuangan_id" class="h-12 w-full rounded-lg border border-gray-300 bg-white pl-4 pr-10 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 shadow-theme-xs appearance-none">
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 7.5L10 12.5L15 7.5" stroke="#64748B" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                    </div>
                </div>

                <!-- 3. Nominal -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Nominal (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">Rp</span>
                        <input type="text" name="nominal" x-model="data.nominal" x-on:input="formatRupiah($event)" class="h-12 w-full rounded-lg border border-gray-300 bg-white pl-10 pr-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 shadow-theme-xs">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-5">
                <!-- 4. Keterangan -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Keterangan</label>
                    <input type="text" name="uraian" x-model="data.uraian" class="h-12 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 shadow-theme-xs">
                </div>

                <!-- 5. Tanggal -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500 dark:text-gray-400">
                           <svg class="fill-current w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                               <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6667 2.5H15V1.66667C15 1.20643 14.6269 0.833333 14.1667 0.833333C13.7064 0.833333 13.3333 1.20643 13.3333 1.66667V2.5H6.66667V1.66667C6.66667 1.20643 6.29357 0.833333 5.83333 0.833333C5.3731 0.833333 5 1.20643 5 1.66667V2.5H3.33333C2.41286 2.5 1.66667 3.24619 1.66667 4.16667V15.8333C1.66667 16.7538 2.41286 17.5 3.33333 17.5H16.6667C17.5871 17.5 18.3333 16.7538 18.3333 15.8333V4.16667C18.3333 3.24619 17.5871 2.5 16.6667 2.5ZM16.6667 5.83333H3.33333V4.16667H16.6667V5.83333ZM3.33333 7.5V15.8333H16.6667V7.5H3.33333Z" fill="currentColor"/>
                           </svg>
                        </span>
                        <input type="text" id="edit-tanggal-input" name="tanggal" x-model="data.tanggal" placeholder="DD-MM-YYYY"
                            class="datepicker h-12 w-full rounded-lg border border-gray-300 bg-white pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800 shadow-theme-xs">
                    </div>
                </div>

                <!-- 6. Bukti -->
                <div>
                     <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Tambah Bukti Baru</label>
                     <div class="flex flex-col items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="files.length === 0">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Bukti baru akan ditambahkan (bisa multiple)</p>
                            </div>
                            <div class="flex flex-col items-center justify-center pt-5 pb-6" x-show="files.length > 0">
                                <svg class="w-8 h-8 mb-4 text-brand-500 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="mb-2 text-sm font-semibold text-gray-700 dark:text-white" x-text="files.length + ' File Siap Diupload'"></p>
                                <template x-for="file in files">
                                    <p class="text-xs text-gray-500 dark:text-gray-400" x-text="file.name"></p>
                                </template>
                            </div>
                            <input type="file" name="bukti_file[]" multiple class="hidden" @change="handleFileChange" />
                        </label>
                    </div>  
                </div>
            </div>
        </div>

        <!-- Footer Buttons -->
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700 mt-6">
            <button type="button" @click="open = false" 
                class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700 transition-colors">
                Batal
            </button>
            <button type="submit" 
                class="px-5 py-2.5 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 focus:outline-none focus:ring-4 focus:ring-brand-500/20 shadow-lg shadow-brand-500/10 transition-colors">
                Perbarui Transaksi
            </button>
        </div>
    </form>
</x-ui.modal>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("Flatpickr init");
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d", // Submitted format
            altInput: true,     // Show alternate format
            altFormat: "d-m-Y", // Display format
            allowInput: true,   // Allow manual typing
            monthSelectorType: 'static'
        });
    });

    function openEditModal(data) {
        window.dispatchEvent(new CustomEvent('open-edit-modal', { detail: data }));
    }

    // Chart data from backend
    const chartData = @json($chartData ?? [
        'dates' => [],
        'pemasukan' => [],
        'pengeluaran' => []
    ]);

    const options = {
        series: [
            { name: 'Pemasukan', data: chartData.pemasukan }, 
            { name: 'Pengeluaran', data: chartData.pengeluaran }
        ],
        chart: { 
            type: 'area', 
            height: 350, 
            toolbar: { show: false }, 
            fontFamily: 'Inter, sans-serif' 
        },
        colors: ['#10B981', '#EF4444'],
        stroke: { curve: 'smooth', width: 3 },
        fill: { 
            type: 'gradient', 
            gradient: { 
                shadeIntensity: 1, 
                opacityFrom: 0.4, 
                opacityTo: 0.05, 
                stops: [0, 90, 100] 
            } 
        },
        dataLabels: { enabled: false },
        xaxis: { 
            categories: chartData.dates, 
            axisBorder: { show: false }, 
            axisTicks: { show: false },
            labels: { style: { colors: '#9CA3AF' } }
        },
        yaxis: { 
            labels: { 
                style: { colors: '#9CA3AF' },
                formatter: function(val) {
                    return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
            },
        },
        grid: { 
            borderColor: '#374151',
            strokeDashArray: 4,
            xaxis: { lines: { show: false } },   
            yaxis: { lines: { show: true } } 
        },
        tooltip: { 
            theme: false,
            style: {
                fontSize: '14px',
                fontFamily: 'Inter, sans-serif',
            },
            marker: { show: true },
            x: { show: true },
            custom: function({series, seriesIndex, dataPointIndex, w}) {
                const date = w.globals.categoryLabels[dataPointIndex];
                
                let content = `<div class="min-w-[180px] px-3 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl">`;
                content += `<div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2 pb-2 border-b border-gray-100 dark:border-gray-700">${date}</div>`;
                
                w.config.series.forEach((s, index) => {
                    const val = series[index][dataPointIndex];
                    const formattedVal = "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    const color = w.config.colors[index];
                    const seriesName = s.name;
                    
                    content += `
                        <div class="flex items-center justify-between gap-4 mb-1.5 last:mb-0">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" style="background-color: ${color}"></span>
                                <span class="text-xs font-medium text-gray-600 dark:text-gray-300">${seriesName}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white tabular-nums">${formattedVal}</span>
                        </div>
                    `;
                });
                
                content += `</div>`;
                return content;
            }
        }
    };
    
    const chart = new ApexCharts(document.querySelector("#chartKeuangan"), options);
    chart.render();
</script>
@endsection
