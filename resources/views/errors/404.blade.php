@extends('layouts.guest')

@section('title', 'Halaman Tidak Ditemukan')
@section('heading', 'Halaman Tidak Ditemukan')
@section('subheading', 'Halaman yang Anda cari tidak tersedia atau sudah dipindahkan.')

@section('content')
    <a
        href="{{ auth()->check() ? route('dashboard') : route('login') }}"
        class="inline-flex w-full items-center justify-center rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
    >
        {{ auth()->check() ? 'Kembali ke Dashboard' : 'Kembali ke Halaman Masuk' }}
    </a>
@endsection
