{{-- resources/views/components/ecommerce/ecommerce-metrics.blade.php --}}
@props(['totalUser', 'totalDivisions', 'totalActivity', 'totalCommunities'])

<div class="w-full">

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3 md:gap-6 2xl:gap-8">

        {{-- KARTU 1: TOTAL ANGGOTA --}}
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 md:p-8 2xl:p-10 dark:border-gray-800 dark:bg-white/[0.03] shadow-sm transition-all hover:shadow-md">
            {{-- Angka Utama (Scaling font-size) --}}
            <h4 class="text-2xl font-bold text-gray-800 md:text-3xl 2xl:text-4xl dark:text-white/90">
                {{ number_format($totalUser) }}
            </h4>

            <div class="mt-4 flex items-end justify-between sm:mt-5 2xl:mt-8">
                <div>
                    <p class="mt-1 text-sm font-medium text-gray-500 md:text-base dark:text-gray-400">
                        Total Anggota
                    </p>
                </div>

                <div class="flex items-center gap-1.5">
                    {{-- <span
                    class="flex items-center gap-1 rounded-full bg-success-50 px-2 py-0.5 text-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                    Active
                </span> --}}

                </div>
            </div>
        </div>

        {{-- KARTU 2: TOTAL DIVISI --}}
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 md:p-8 2xl:p-10 dark:border-gray-800 dark:bg-white/[0.03] shadow-sm transition-all hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    {{-- Angka Utama: Komunitas --}}
                    <h4 class="text-2xl font-bold text-gray-800 md:text-3xl 2xl:text-4xl dark:text-white/90">
                        {{ number_format($totalCommunities) }}
                    </h4>
                    <p class="mt-7  text-sm font-medium text-gray-500 md:text-base dark:text-gray-400">
                        Total Komunitas
                    </p>
                </div>
                {{-- Ikon atau Label Status
                <span
                    class="flex items-center gap-1 rounded-full bg-success-50 px-2 py-0.5 text-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                    Active
                </span> --}}

            </div>

            {{-- Pemisah Visual --}}
            <div class="my-4 border-t border-gray-100 dark:border-gray-800"></div>

            {{-- Angka Sekunder: Divisi --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="h-2 w-2 rounded-full bg-[#3C50E0]"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Divisi</span>
                </div>
                <span class="text-base font-bold text-gray-800 dark:text-white/90">
                    {{ number_format($totalDivisions) }}
                </span>
            </div>
        </div>

        {{-- KARTU 3: TOTAL ACARA / KEGIATAN --}}
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 md:p-8 2xl:p-10 dark:border-gray-800 dark:bg-white/[0.03] shadow-sm transition-all hover:shadow-md">
            <h4 class="text-2xl font-bold text-gray-800 md:text-3xl 2xl:text-4xl dark:text-white/90">
                {{ number_format($totalActivity) }}
            </h4>

            <div class="mt-4 flex items-end justify-between sm:mt-5 2xl:mt-8">
                <div>
                    <p class="mt-1 text-sm font-medium text-gray-500 md:text-base dark:text-gray-400">
                        Acara / Kegiatan
                    </p>
                </div>

                <div class="flex items-center gap-1.5">

                    {{-- <span
                        class="flex items-center gap-1 rounded-full bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-600 dark:bg-blue-500/15 dark:text-blue-400 ">
                        Events
                    </span> --}}
                </div>
            </div>
        </div>

    </div>
</div>
