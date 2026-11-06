@props(['type' => 'info'])

@php
    $styles = match ($type) {
        'success' => 'border-green-200 bg-green-50 text-green-800 dark:border-green-800 dark:bg-gray-800 dark:text-green-400',
        'error' => 'border-red-200 bg-red-50 text-red-800 dark:border-red-800 dark:bg-gray-800 dark:text-red-400',
        'warning' => 'border-yellow-200 bg-yellow-50 text-yellow-800 dark:border-yellow-800 dark:bg-gray-800 dark:text-yellow-300',
        default => 'border-blue-200 bg-blue-50 text-blue-800 dark:border-blue-800 dark:bg-gray-800 dark:text-blue-400',
    };

    $icon = match ($type) {
        'success' => 'check-circle',
        'error', 'warning' => 'exclamation',
        default => 'exclamation',
    };
@endphp

<div role="alert" {{ $attributes->merge(['class' => 'flex items-start gap-3 rounded-lg border p-4 text-sm '.$styles]) }}>
    <x-icon :name="$icon" class="mt-0.5 h-5 w-5 shrink-0" />
    <div class="space-y-1">{{ $slot }}</div>
</div>
