@props([
    'label' => '',
    'name' => 'options',
    'options' => [],        // [{id:1,name:'A'}]
    'selected' => [],       // [1,3]
    'placeholder' => 'Select options...',
])

<div>
    @if($label)
        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ $label }}
        </label>
    @endif

    <div
        x-data="{
            open: false,
            selected: @js($selected),
            options: @js($options),
            toggleOption(id) {
                this.selected.includes(id)
                    ? this.selected = this.selected.filter(i => i !== id)
                    : this.selected.push(id)
            },
            isSelected(id) {
                return this.selected.includes(id)
            }
        }"
        class="relative"
        @click.away="open = false"
    >
        <!-- hidden input (array) -->
        <template x-for="id in selected" :key="id">
            <input type="hidden" :name="'{{ $name }}[]'" :value="id">
        </template>

        <!-- trigger -->
        <div @click="open = !open"
            class="shadow-theme-xs flex min-h-11 cursor-pointer gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 transition dark:border-gray-700 dark:bg-gray-900">

            <div class="flex flex-1 flex-wrap items-center gap-2">
                <template x-for="id in selected" :key="id">
                    <div
                        class="flex items-center rounded-full bg-gray-100 py-1 pl-2.5 pr-2 text-sm
                               text-gray-800 dark:bg-gray-800 dark:text-white/90">
                        <span x-text="options.find(o => o.id === id)?.name"></span>
                        <button type="button" @click.stop="toggleOption(id)"
                            class="ml-1 text-gray-500 hover:text-gray-700 dark:text-gray-400">
                            ✕
                        </button>
                    </div>
                </template>

                <span x-show="selected.length === 0"
                    class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $placeholder }}
                </span>
            </div>

            <svg class="h-5 w-5 text-gray-500 transition-transform dark:text-gray-400"
                :class="open && 'rotate-180'"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <!-- dropdown -->
        <div x-show="open"
            class="absolute z-50 mt-1 w-full overflow-hidden rounded-lg border border-gray-200
                   bg-white dark:border-gray-700 dark:bg-gray-900">
            <template x-for="option in options" :key="option.id">
                <div @click="toggleOption(option.id)"
                    class="cursor-pointer px-4 py-3 text-sm transition
                           hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="text-gray-800 dark:text-white/90"
                        x-text="option.name"></span>
                </div>
            </template>
        </div>
    </div>
</div>
