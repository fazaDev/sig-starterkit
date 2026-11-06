@extends('layouts.guest')

@section('title', 'Masuk')
@section('heading', 'Masuk ke Panel Admin')
@section('subheading', 'Gunakan email dan password yang diberikan administrator.')

@section('content')
    @if (session('status'))
        <x-alert type="success" class="mb-4">{{ session('status') }}</x-alert>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
        @csrf

        <div>
            <x-label for="email">Email</x-label>
            <x-input
                name="email"
                type="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="nama@perusahaan.com"
            />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-label for="password">Password</x-label>
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-700 hover:underline dark:text-blue-500">
                    Lupa password?
                </a>
            </div>

            <x-input name="password" type="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <input
                type="checkbox"
                name="remember"
                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800"
                @checked(old('remember'))
            >
            Ingat saya
        </label>

        <x-primary-button class="w-full">Masuk</x-primary-button>
    </form>
@endsection
