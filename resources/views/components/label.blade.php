@props(['for' => null])

<label
    @if ($for) for="{{ $for }}" @endif
    {{ $attributes->merge(['class' => 'mb-2 block text-sm font-medium text-gray-900 dark:text-white']) }}
>
    {{ $slot }}
</label>
