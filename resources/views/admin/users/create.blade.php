@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <x-page-header title="Tambah Pengguna" description="Buat akun baru dan tentukan role yang dimiliki.">
        <x-slot:actions>
            <a
                href="{{ route('admin.users.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700"
            >
                <x-icon name="arrow-left" class="h-4 w-4" />
                Kembali
            </a>
        </x-slot:actions>
    </x-page-header>

    <form method="POST" action="{{ route('admin.users.store') }}" class="max-w-3xl space-y-6">
        @csrf

        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            @include('admin.users._form', ['user' => null])
        </div>

        <div class="flex items-center gap-3">
            <x-primary-button>Simpan Pengguna</x-primary-button>

            <a
                href="{{ route('admin.users.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700"
            >
                Batal
            </a>
        </div>
    </form>
@endsection
