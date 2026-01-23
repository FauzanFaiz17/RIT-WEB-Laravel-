{{-- resources/views/components/ecommerce/upcoming-activities.blade.php --}}
@props(['upcomingActivities'])

<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-8 2xl:p-10 h-full flex flex-col shadow-sm">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-lg md:text-xl font-bold text-gray-800 dark:text-white/90">Agenda Organisasi</h3>
            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mt-1">Kegiatan mendatang & sedang berlangsung</p>
        </div>
        <a href="/calendar" class="text-sm font-semibold text-[#3C50E0] hover:underline">Lihat Semua</a>
    </div>

    <div class="space-y-7 flex-1">
        @forelse($upcomingActivities as $activity)
            @php
                $startDate = \Carbon\Carbon::parse($activity->start_date);
                $isToday = $startDate->isToday();
                $isOngoing = $startDate->isPast() && $isToday; // Logika sederhana sedang berlangsung hari ini
                
                $daysRemaining = intval(now()->startOfDay()->diffInDays($startDate->startOfDay(), false));
                $daysRemaining = max(0, $daysRemaining);

                $isAcara = strtolower($activity->type ?? '') === 'acara';
                
                // PENENTUAN STATUS & WARNA BAR
                if ($isToday) {
                    $textStatus = 'Sedang Berlangsung';
                    $colorClass = 'bg-success-500'; // Hijau untuk yang sedang jalan
                    $badgeBase = 'bg-success-50 text-success-700 border-success-200 dark:bg-success-500/10 dark:text-success-500';
                } elseif ($daysRemaining <= 2) {
                    $textStatus = 'Sangat Dekat';
                    $colorClass = 'bg-red-500';
                    $badgeBase = $isAcara ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-blue-50 text-blue-700 border-blue-200';
                } else {
                    $textStatus = 'Mendatang';
                    $colorClass = $isAcara ? 'bg-amber-500' : 'bg-[#3C50E0]';
                    $badgeBase = $isAcara ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-blue-50 text-blue-700 border-blue-200';
                }
            @endphp

            <div class="flex items-center w-full group gap-4">
                {{-- AREA 1: INFO (KIRI) --}}
                <div class="flex items-center gap-4 w-1/3 min-w-0">
                    <div class="flex h-12 w-12 md:h-14 md:w-14 flex-shrink-0 items-center justify-center rounded-2xl {{ $isToday ? 'bg-success-50 dark:bg-success-900/20 text-success-600' : ($isAcara ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600' : 'bg-blue-50 dark:bg-blue-900/20 text-blue-600') }} transition-all duration-300">
                        <svg class="size-6 md:size-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    
                    <div class="min-w-0 flex flex-col">
                        <p class="text-sm md:text-base font-bold text-gray-800 dark:text-white/90 truncate">
                            {{ $activity->title ?? 'Tanpa Nama' }}
                        </p>
                        <span class="block text-[10px] md:text-xs text-gray-400 mt-0.5">
                            {{ $startDate->translatedFormat('d F Y') }}
                        </span>
                    </div>
                </div>

                {{-- AREA 2: BADGE TENGAH (Label Kategori & Status) --}}
                <div class="w-1/3 flex flex-col items-center gap-1">
                    <span class="px-2.5 py-0.5 rounded text-[9px] md:text-[10px] font-bold uppercase border {{ $isToday ? 'bg-success-50 text-success-700 border-success-200' : ($isAcara ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-blue-50 text-blue-700 border-blue-200') }}">
                        {{ $activity->type ?? 'Kegiatan' }}
                    </span>
                    <span class="text-[9px] font-bold {{ $isToday ? 'text-success-600' : ($daysRemaining <= 2 ? 'text-red-500' : 'text-gray-400') }}">
                        {{ $textStatus }}
                    </span>
                </div>

                {{-- AREA 3: PROGRES (KANAN) --}}
                <div class="w-1/3 flex flex-col items-end gap-1.5">
                    <span class="text-xs md:text-sm font-bold text-gray-700 dark:text-gray-300">
                        {{ $isToday ? 'Hari Ini' : $daysRemaining . ' Hari lagi' }}
                    </span>
                    <div class="h-1.5 w-full max-w-[100px] md:max-w-[120px] rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                        <div class="h-full {{ $colorClass }} transition-all duration-1000" 
                             style="width: {{ $isToday ? '100' : max(15, 100 - ($daysRemaining * 10)) }}%"></div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-16 opacity-50">
                <p class="text-sm font-medium text-gray-500">Tidak ada agenda saat ini.</p>
            </div>
        @endforelse
    </div>
</div>