@props(['href', 'active' => false, 'icon' => null])

<a
    href="{{ $href }}"
    @if ($active) aria-current="page" @endif
    @class([
        'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition',
        'bg-blue-50 text-blue-700 dark:bg-gray-700 dark:text-white' => $active,
        'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' => ! $active,
    ])
>
    @if ($icon)
        <x-icon :name="$icon" class="h-5 w-5 shrink-0" />
    @endif

    <span>{{ $slot }}</span>
</a>
