<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') &mdash; {{ config('app.name') }}</title>

    @include('partials.theme-init')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-gray-50 text-gray-900 antialiased dark:bg-gray-900 dark:text-gray-100">
    <div class="lg:pl-64">
        @include('partials.sidebar')
        @include('partials.topbar')

        <main class="p-4 sm:p-6 lg:p-8">
            <div class="mx-auto max-w-7xl space-y-6">
                @if (session('status'))
                    <x-alert type="success">{{ __(session('status')) }}</x-alert>
                @endif

                @if (session('error'))
                    <x-alert type="error">{{ session('error') }}</x-alert>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('modals')

    @stack('scripts')
</body>
</html>
