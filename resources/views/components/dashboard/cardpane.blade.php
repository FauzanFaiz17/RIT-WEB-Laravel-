@props([
  'value' => '',
  'label' => '',
  'change' => null,      // angka persen (boleh + / -)
  'period' => 'From last month',
])
<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
  <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
    {{ $value }}
  </h4>

  <div class="mt-4 flex items-end justify-between sm:mt-5">
    <div>
      <p class="text-theme-sm text-gray-700 dark:text-gray-400">
        {{ $label }}
      </p>
    </div>

    <div class="flex items-center gap-1">
      @if(!is_null($change))
        <span
          class="flex items-center gap-1 rounded-full px-2 py-0.5 text-theme-xs font-medium
          {{ $change >= 0
              ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
              : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'
          }}">
          {{ $change > 0 ? '+' : '' }}{{ $change }}%
        </span>
      @endif

      <span class="text-theme-xs text-gray-500 dark:text-gray-400">
        {{ $period }}
      </span>
    </div>
  </div>
</div>
