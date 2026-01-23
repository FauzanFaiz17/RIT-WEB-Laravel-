@extends('layouts.app')

{{-- SECTION: INITIALIZATION & HELPER LOGIC --}}
@php
    use Illuminate\Support\HtmlString;
    
    // Icon Definition
    $AddIcon = new HtmlString(
        '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 4.16663V15.8333" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M4.16663 10H15.8333" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>',
    );

    // Status Badge Styling Helper
    function getStatusBadge($status)
    {
        $baseClasses = 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium';
        switch ($status) {
            case 'completed':
                return "$baseClasses bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400";
            case 'progress':
                return "$baseClasses bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400";
            default:
                return "$baseClasses bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400";
        }
    }

    // Status Label Helper
    function getStatusLabel($status)
    {
        switch ($status) {
            case 'completed': return 'Selesai';
            case 'progress': return 'Sedang Berjalan';
            default: return 'Belum Dimulai';
        }
    }
@endphp

@section('content')
    {{-- SECTION: ALPINE.js MAIN CONTAINER --}}
    <div x-data="{
        showAddModal: false, 
        showDetailModal: false,
        selectedItem: null,
    
        openDetail(item) {
            this.selectedItem = JSON.parse(JSON.stringify(item));
            this.showDetailModal = true;
        },
    
        formatDate(dateString) {
            if (!dateString) return '';
            return dateString.replace(' ', 'T').substring(0, 16);
        }
    }">

        <div class="mx-auto max-w-full p-4 md:p-6 2xl:p-10">

            {{-- SECTION: HEADER & FILTER COMPONENT --}}
            <div class="flex flex-col gap-5 mb-6 sm:flex-row sm:items-center sm:justify-between">
                {{-- Title and Subtitle --}}
                <div class="w-full sm:w-auto">
                    <h2 class="text-title-md2 font-bold text-black dark:text-white">
                        Daftar {{ ucfirst($pageType) }}
                    </h2>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Kelola data {{ $pageType }} organisasi Anda di sini.
                    </p>
                </div>

                {{-- Action Buttons & Filter --}}
                <div class="flex flex-wrap items-center gap-3">
                    {{-- Form Filter Status --}}
                    <form action="{{ url()->current() }}" method="GET" class="w-full sm:w-auto">
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500 dark:text-gray-400">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                            </span>

                            <select name="status" onchange="this.form.submit()"
                                class="w-full sm:w-48 appearance-none rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-10 text-sm font-medium text-gray-700 outline-none transition focus:border-[#3C50E0] active:border-[#3C50E0] dark:border-gray-700 dark:bg-gray-800 dark:text-white cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="progress" {{ request('status') == 'progress' ? 'selected' : '' }}>Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>

                            <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500 dark:text-gray-400">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </div>
                    </form>

                    {{-- Add Button --}}
                    <button @click="showAddModal = true"
                        class="inline-flex flex-1 sm:flex-none items-center justify-center gap-2 rounded-lg bg-[#3C50E0] px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-opacity-90 transition">
                        {!! $AddIcon !!}
                        <span class="whitespace-nowrap">Tambah {{ ucfirst($pageType) }}</span>
                    </button>
                </div>
            </div>

            {{-- SECTION: DATA TABLE LIST --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <table class="w-full min-w-[1000px] table-auto">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                                <th class="px-5 py-4 text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">Detail Kegiatan</th>
                                <th class="px-5 py-4 text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">Tanggal Mulai</th>
                                <th class="px-5 py-4 text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">Tanggal Selesai</th>
                                <th class="px-5 py-4 text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">Lokasi</th>
                                <th class="px-5 py-4 text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</th>
                                <th class="px-5 py-4 text-right font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $activity)
                                <tr class="border-b border-gray-100 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                                    {{-- Detail Cell --}}
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                                @if ($activity->type == 'acara')
                                                    <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21v-8a2 2 0 012-2h10a2 2 0 012 2v8m2-2a2 2 0 01-2-2h-5a2 2 0 01-2-2H4a2 2 0 01-2 2v2m2-2v6" /></svg>
                                                @else
                                                    <svg class="w-5 h-5 text-[#3C50E0]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="block font-medium text-gray-800 text-sm dark:text-white/90">{{ $activity->title }}</span>
                                                <span class="block text-gray-500 text-xs dark:text-gray-400">{{ Str::limit($activity->description, 40) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- Start Date Cell --}}
                                    <td class="px-5 py-4">
                                        <div class="text-sm font-medium text-gray-800 dark:text-white/90">{{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($activity->start_date)->format('H:i') }} WIB</div>
                                    </td>
                                    {{-- End Date Cell --}}
                                    <td class="px-5 py-4">
                                        @if ($activity->end_date)
                                            <div class="text-sm font-medium text-gray-800 dark:text-white/90">{{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($activity->end_date)->format('H:i') }} WIB</div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    {{-- Location Cell --}}
                                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $activity->location ?? '-' }}</td>
                                    {{-- Status Cell --}}
                                    <td class="px-5 py-4">
                                        <span class="{{ getStatusBadge($activity->status ?? 'pending') }}">{{ getStatusLabel($activity->status ?? 'pending') }}</span>
                                    </td>
                                    {{-- Actions Cell --}}
                                    <td class="px-5 py-4 text-right">
                                        <button @click="openDetail({{ $activity }})" class="text-gray-500 hover:text-primary transition-colors">
                                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.69 1.07l-3.266 1.053a.375.375 0 01-.48-.481L6.2 14.456a4.5 4.5 0 011.069-1.691l7.759-7.761c.229-.228.537-.228.766 0z" /></svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-5 py-10 text-center text-gray-500">Data Kosong</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
                    {{ $activities->links() }}
                </div>
            </div>
        </div>

        {{-- SECTION: MODAL ADD ACTIVITY --}}
        <div x-show="showAddModal" style="display: none;"
            class="fixed inset-0 z-[999999] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm px-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="w-full max-w-lg rounded-xl border border-gray-200 bg-white p-6 shadow-2xl dark:border-gray-700 dark:bg-gray-800"
                @click.outside="showAddModal = false">
                <div class="mb-6 flex items-center justify-between border-b border-gray-100 pb-4 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Tambah {{ ucfirst($pageType) }}</h3>
                    <button @click="showAddModal = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">✕</button>
                </div>

                <form action="{{ $unitId ? route('activities.store', $unitId) : '#' }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="{{ $pageType }}">
                    <div class="space-y-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
                            <input type="text" name="title" required placeholder="Contoh: Rapat Pleno"
                                class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status"
                                class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                                <option value="pending">Belum Dimulai (Pending)</option>
                                <option value="progress">Sedang Berjalan (Progress)</option>
                                <option value="completed">Selesai (Completed)</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Mulai</label>
                                <input type="datetime-local" name="start_date" required
                                    class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Selesai</label>
                                <input type="datetime-local" name="end_date"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                            </div>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi</label>
                            <input type="text" name="location" placeholder="Gedung Utama"
                                class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                            <textarea name="description" rows="3" placeholder="Detail tambahan..."
                                class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white"></textarea>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="showAddModal = false"
                            class="rounded-lg border border-gray-300 py-2 px-5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">Batal</button>
                        <button type="submit"
                            class="rounded-lg bg-[#3C50E0] py-2 px-5 text-sm font-medium text-white hover:bg-opacity-90 shadow-sm transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- SECTION: MODAL EDIT ACTIVITY --}}
        <div x-show="showDetailModal" style="display: none;"
            class="fixed inset-0 z-[999999] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm px-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="w-full max-w-lg rounded-xl border border-gray-200 bg-white p-6 shadow-2xl dark:border-gray-700 dark:bg-gray-800"
                @click.outside="showDetailModal = false">
                <div class="mb-6 flex items-center justify-between border-b border-gray-100 pb-4 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Edit {{ ucfirst($pageType) }}</h3>
                    <button @click="showDetailModal = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">✕</button>
                </div>

                <form x-bind:action="'{{ url('activities') }}/' + (selectedItem ? selectedItem.id : '')" method="POST">
                    @csrf
                    @method('PUT')

                    <template x-if="selectedItem">
                        <div>
                            <input type="hidden" name="type" :value="selectedItem.type">
                            <div class="space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
                                    <input type="text" name="title" x-model="selectedItem.title" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <select name="status" x-model="selectedItem.status"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                                        <option value="pending">Belum Dimulai (Pending)</option>
                                        <option value="progress">Sedang Berjalan (Progress)</option>
                                        <option value="completed">Selesai (Completed)</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Mulai</label>
                                        <input type="datetime-local" name="start_date"
                                            :value="formatDate(selectedItem.start_date)"
                                            @input="selectedItem.start_date = $event.target.value" required
                                            class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Selesai</label>
                                        <input type="datetime-local" name="end_date"
                                            :value="formatDate(selectedItem.end_date)"
                                            @input="selectedItem.end_date = $event.target.value"
                                            class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi</label>
                                    <input type="text" name="location" x-model="selectedItem.location"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                    <textarea name="description" rows="3" x-model="selectedItem.description"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-4 text-sm outline-none focus:border-[#3C50E0] focus:ring-1 focus:ring-[#3C50E0] dark:border-gray-600 dark:bg-gray-900 dark:text-white"></textarea>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="mt-8 flex justify-between items-center">
                        {{-- Trigger Delete --}}
                        <button type="button"
                            @click="if(confirm('Yakin ingin menghapus?')) { document.getElementById('delete-form-' + selectedItem.id).submit(); }"
                            class="text-red-500 hover:text-red-700 font-medium text-sm flex items-center gap-1 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                        {{-- Form Control Buttons --}}
                        <div class="flex gap-3">
                            <button type="button" @click="showDetailModal = false"
                                class="rounded-lg border border-gray-300 py-2 px-5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">Batal</button>
                            <button type="submit"
                                class="rounded-lg bg-[#3C50E0] py-2 px-5 text-sm font-medium text-white hover:bg-opacity-90 shadow-sm transition">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- SECTION: HIDDEN DELETE FORMS --}}
        @foreach ($activities as $act)
            <form id="delete-form-{{ $act->id }}" action="{{ route('activities.destroy', $act->id) }}"
                method="POST" class="hidden">
                @csrf @method('DELETE')
            </form>
        @endforeach

    </div>
@endsection