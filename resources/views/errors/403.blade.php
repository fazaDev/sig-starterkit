@extends('layouts.guest')

@section('title', 'Akses Ditolak')
@section('heading', 'Akses Ditolak')
@section('subheading', 'Anda tidak memiliki izin untuk membuka halaman ini.')

@section('content')
    <div class="space-y-5">
        <div class="flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-800 dark:bg-gray-800 dark:text-red-400">
            <x-icon name="lock" class="mt-0.5 h-5 w-5 shrink-0" />
            <p>Hubungi administrator apabila Anda membutuhkan akses ke halaman ini.</p>
        </div>

        <a
            href="{{ auth()->check() ? route('profile.edit') : route('login') }}"
            class="inline-flex w-full items-center justify-center rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        >
            {{ auth()->check() ? 'Kembali ke Profil' : 'Kembali ke Halaman Masuk' }}
        </a>
    </div>
@endsection
