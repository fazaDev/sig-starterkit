@extends('layouts.guest')

@section('title', 'Lupa Password')
@section('heading', 'Lupa Password')
@section('subheading', 'Masukkan email Anda dan kami akan mengirimkan tautan untuk membuat password baru.')

@section('content')
    @if (session('status'))
        <x-alert type="success" class="mb-4">{{ session('status') }}</x-alert>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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

        <x-primary-button class="w-full">Kirim tautan reset</x-primary-button>

        <p class="text-center text-sm">
            <a href="{{ route('login') }}" class="font-medium text-blue-700 hover:underline dark:text-blue-500">
                Kembali ke halaman masuk
            </a>
        </p>
    </form>
@endsection
