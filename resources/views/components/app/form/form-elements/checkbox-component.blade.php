@props([
    'label' => '',
    'name' => '',
    'value' => 1,
    'checked' => false,
    'disabled' => false,
])

<div 
    x-data="{ checkboxToggle: @js($checked) }"
    class="flex items-center"
>
    <label class="flex cursor-pointer items-center text-sm font-medium select-none
        {{ $disabled ? 'text-gray-300 dark:text-gray-700 cursor-not-allowed' : 'text-gray-700 dark:text-gray-400' }}">
        
        <div class="relative">
            <input
                type="checkbox"
                name="{{ $name }}"
                value="{{ $value }}"
                {{ $checked ? 'checked' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                class="sr-only"
                @change="checkboxToggle = !checkboxToggle"
            />

            <div
                :class="checkboxToggle 
                    ? 'border-brand-500 bg-brand-500' 
                    : 'bg-transparent border-gray-300 dark:border-gray-700'"
                class="mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]"
            >
                <span :class="checkboxToggle ? '' : 'opacity-0'">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7"
                            stroke="white"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
            </div>
        </div>

        {{ $label }}
    </label>
</div>
