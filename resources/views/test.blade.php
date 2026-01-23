@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-(--breakpoint-2xl) p-4 pb-20 md:p-6 md:pb-6">
            <div class="grid grid-cols-12 gap-4 md:gap-6">
              <div class="col-span-12">
                <!-- Metric Group Four -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-3">
  <!-- Metric Item Start -->
  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
    <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
      $120,369
    </h4>

    <div class="mt-4 flex items-end justify-between sm:mt-5">
      <div>
        <p class="text-theme-sm text-gray-700 dark:text-gray-400">
          Active Deal
        </p>
      </div>

      <div class="flex items-center gap-1">
        <span class="flex items-center gap-1 rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
          +20%
        </span>

        <span class="text-theme-xs text-gray-500 dark:text-gray-400">
          From last month
        </span>
      </div>
    </div>
  </div>
  <!-- Metric Item End -->

  <!-- Metric Item Start -->
  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
    <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
      $234,210
    </h4>

    <div class="mt-4 flex items-end justify-between sm:mt-5">
      <div>
        <p class="text-theme-sm text-gray-700 dark:text-gray-400">
          Revenue Total
        </p>
      </div>

      <div class="flex items-center gap-1">
        <span class="flex items-center gap-1 rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
          +9.0%
        </span>

        <span class="text-theme-xs text-gray-500 dark:text-gray-400">
          From last month
        </span>
      </div>
    </div>
  </div>
  <!-- Metric Item End -->

  <!-- Metric Item Start -->
  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
    <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
      874
    </h4>

    <div class="mt-4 flex items-end justify-between sm:mt-5">
      <div>
        <p class="text-theme-sm text-gray-700 dark:text-gray-400">
          Closed Deals
        </p>
      </div>

      <div class="flex items-center gap-1">
        <span class="flex items-center gap-1 rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
          -4.5%
        </span>

        <span class="text-theme-xs text-gray-500 dark:text-gray-400">
          From last month
        </span>
      </div>
    </div>
  </div>
  <!-- Metric Item End -->
</div>
<!-- Metric Group Four -->
              </div>

              <div class="col-span-12 xl:col-span-8">
                <!-- ====== Chart Eleven Start -->
                <x-dashboard.statistik-keuangan />
<!-- ====== Chart Eleven End -->
              </div>

              <div class="col-span-12 xl:col-span-4">
                <!-- ====== Chart Twelve Start -->
<x-dashboard.list-project />




<!-- ====== Chart Twelve End -->
              </div>

              <div class="col-span-12 xl:col-span-6">
                <!-- ====== Chart Thirteen Start -->
         <x-dashboard.mayoritas/>
<!-- ====== Chart Thirteen End -->
              </div>

              <div class="col-span-12 xl:col-span-6">
                <!-- ====== Upcoming Schedule Start -->
                <x-dashboard.aktifitas/>
<!-- ====== Upcoming Schedule End -->

<!-- Table Four -->
              </div>
            </div>
          </div>
@endsection
