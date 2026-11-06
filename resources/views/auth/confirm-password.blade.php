@extends('layouts.guest')

@section('title', 'Konfirmasi Password')
@section('heading', 'Konfirmasi Password')
@section('subheading', 'Demi keamanan, silakan masukkan password Anda kembali sebelum melanjutkan.')

@section('content')
    <form method="POST" action="{{ route('password.confirm.store') }}" class="space-y-4">
        @csrf

        <div>
            <x-label for="password">Password</x-label>
            <x-input name="password" type="password" required autofocus autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <x-primary-button class="w-full">Konfirmasi</x-primary-button>
    </form>
@endsection
