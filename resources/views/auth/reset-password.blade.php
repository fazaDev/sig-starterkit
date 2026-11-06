@extends('layouts.guest')

@section('title', 'Reset Password')
@section('heading', 'Buat Password Baru')
@section('subheading', 'Masukkan password baru untuk akun Anda.')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-label for="email">Email</x-label>
            <x-input
                name="email"
                type="email"
                :value="old('email', $request->email)"
                required
                autocomplete="username"
                placeholder="nama@perusahaan.com"
            />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-label for="password">Password Baru</x-label>
            <x-input name="password" type="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-label for="password_confirmation">Konfirmasi Password</x-label>
            <x-input name="password_confirmation" type="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <x-primary-button class="w-full">Simpan password baru</x-primary-button>

        <p class="text-center text-sm">
            <a href="{{ route('login') }}" class="font-medium text-blue-700 hover:underline dark:text-blue-500">
                Kembali ke halaman masuk
            </a>
        </p>
    </form>
@endsection
