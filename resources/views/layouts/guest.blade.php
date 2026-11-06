<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Masuk') &mdash; {{ config('app.name') }}</title>

    @include('partials.theme-init')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col items-center justify-center bg-gray-50 px-4 py-8 text-gray-900 antialiased dark:bg-gray-900 dark:text-gray-100">
    <div class="mb-6 flex items-center gap-3">
        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-700 text-base font-bold text-white">
            {{ mb_strtoupper(mb_substr(config('app.name'), 0, 1)) }}
        </span>
        <span class="text-xl font-semibold">{{ config('app.name') }}</span>
    </div>

    <div class="w-full max-w-md">
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-8">
            <div class="mb-6">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">@yield('heading')</h1>

                @hasSection('subheading')
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">@yield('subheading')</p>
                @endif
            </div>

            @yield('content')
        </div>
    </div>
</body>
</html>
