@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
    <x-page-header title="Pengguna" description="Kelola akun pengguna beserta role yang dimiliki.">
        <x-slot:actions>
            @can('users.create')
                <a
                    href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    <x-icon name="plus" class="h-4 w-4" />
                    Tambah Pengguna
                </a>
            @endcan
        </x-slot:actions>
    </x-page-header>

    <form
        method="GET"
        action="{{ route('admin.users.index') }}"
        class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800"
    >
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-[1fr_14rem_auto]">
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <x-icon name="search" class="h-5 w-5" />
                </span>

                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama atau email..."
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                >
            </div>

            <select
                name="role"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500"
            >
                <option value="">Semua role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" @selected($roleFilter === $role->name)>{{ $role->name }}</option>
                @endforeach
            </select>

            <div class="flex items-center gap-2">
                <x-primary-button>Terapkan</x-primary-button>

                @if ($search !== '' || $roleFilter !== '')
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </div>
    </form>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-5 py-3">Nama</th>
                        <th scope="col" class="px-5 py-3">Role</th>
                        <th scope="col" class="px-5 py-3">Dibuat</th>
                        <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b border-gray-200 last:border-0 dark:border-gray-700">
                            <td class="px-5 py-3">
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $user->name }}
                                    @if ($user->is(auth()->user()))
                                        <span class="ml-1 text-xs font-normal text-gray-400">(Anda)</span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @forelse ($user->roles as $role)
                                        <span class="rounded bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400 dark:text-gray-500">Tanpa role</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-5 py-3 text-xs">{{ $user->created_at?->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    @can('users.update')
                                        <a
                                            href="{{ route('admin.users.edit', $user) }}"
                                            class="inline-flex items-center gap-1 rounded-lg border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700"
                                        >
                                            <x-icon name="pencil" class="h-4 w-4" />
                                            Ubah
                                        </a>
                                    @endcan

                                    @can('users.delete')
                                        @unless ($user->is(auth()->user()))
                                            <button
                                                type="button"
                                                data-modal-target="delete-user-{{ $user->id }}"
                                                data-modal-toggle="delete-user-{{ $user->id }}"
                                                class="inline-flex items-center gap-1 rounded-lg border border-red-200 bg-white px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 dark:border-red-800 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                                            >
                                                <x-icon name="trash" class="h-4 w-4" />
                                                Hapus
                                            </button>
                                        @endunless
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada pengguna yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-700">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection

@push('modals')
    @can('users.delete')
        @foreach ($users as $user)
            @unless ($user->is(auth()->user()))
                <x-confirm-delete-modal
                    :id="'delete-user-'.$user->id"
                    :action="route('admin.users.destroy', $user)"
                    title="Hapus pengguna?"
                    :description="'Pengguna '.$user->name.' akan dihapus permanen dan tidak dapat dikembalikan.'"
                />
            @endunless
        @endforeach
    @endcan
@endpush
