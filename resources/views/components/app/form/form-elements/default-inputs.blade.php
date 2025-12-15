@props([
    'label' => '',
    'type' => 'text',
    'name' => '',
    'value' => '',
    'placeholder' => '',
])

<div>
    @if($label)
        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ $label }}
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' =>
                'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                 text-gray-800 placeholder:text-gray-400 shadow-theme-xs
                 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-none
                 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30'
        ]) }}
    />
</div>
