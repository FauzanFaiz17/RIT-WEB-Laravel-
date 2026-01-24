@props(['projects'])

<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
  <div class="mb-6 flex items-center justify-between gap-2">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
      Kemajuan Project
    </h3>
  </div>

  <div>
    @forelse ($projects as $project)
      <div class="flex items-center justify-between border-b border-gray-100 py-3 last:border-b-0 dark:border-gray-800">
        <p class="text-theme-sm font-medium text-gray-700 dark:text-gray-300">
          {{ $project['name'] }}
        </p>

        <div class="flex w-full max-w-[140px] items-center gap-3">
          <div class="relative h-2 w-full max-w-[100px] rounded-sm bg-gray-200 dark:bg-gray-800">
            <div
              class="absolute left-0 top-0 h-full rounded-sm bg-brand-500"
              style="width: {{ $project['progress'] }}%">
            </div>
          </div>

          <p class="text-theme-sm font-medium text-gray-700 dark:text-gray-400">
            {{ $project['progress'] }}%
          </p>
        </div>
      </div>
    @empty
      <p class="text-sm text-gray-500 text-center py-4">
        Belum ada project
      </p>
    @endforelse
  </div>

  <a href="{{ route('projects.index') }}"
     class="mt-6 flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white p-2.5 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
    View All
  </a>
</div>

