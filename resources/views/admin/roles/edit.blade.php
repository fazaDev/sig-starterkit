@extends('layouts.app')

@section('title', 'Ubah Role')

@section('content')
    <x-page-header :title="'Ubah Role: '.$role->name" description="Perbarui nama role dan permission yang dimilikinya.">
        <x-slot:actions>
            <a
                href="{{ route('admin.roles.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700"
            >
                <x-icon name="arrow-left" class="h-4 w-4" />
                Kembali
            </a>
        </x-slot:actions>
    </x-page-header>

    <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            @include('admin.roles._form', [
                'role' => $role,
                'rolePermissions' => $rolePermissions,
                'isLocked' => $isLocked,
            ])
        </div>

        <div class="flex items-center gap-3">
            <x-primary-button :disabled="$isLocked">Simpan Perubahan</x-primary-button>

            <a
                href="{{ route('admin.roles.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700"
            >
                Batal
            </a>
        </div>
    </form>
@endsection
