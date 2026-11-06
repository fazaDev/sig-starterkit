@extends('layouts.app')

@section('title', 'Role & Permission')

@section('content')
    <x-page-header title="Role &amp; Permission" description="Atur role dan permission yang dapat diakses oleh setiap pengguna.">
        <x-slot:actions>
            @can('roles.create')
                <a
                    href="{{ route('admin.roles.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    <x-icon name="plus" class="h-4 w-4" />
                    Tambah Role
                </a>
            @endcan
        </x-slot:actions>
    </x-page-header>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-5 py-3">Role</th>
                        <th scope="col" class="px-5 py-3">Pengguna</th>
                        <th scope="col" class="px-5 py-3">Permission</th>
                        <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        @php($isLocked = (bool) config("rbac.roles.{$role->name}.locked", false))

                        <tr class="border-b border-gray-200 last:border-0 dark:border-gray-700">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $role->name }}</p>

                                    @if ($isLocked)
                                        <span class="rounded bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            Terkunci
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ config("rbac.roles.{$role->name}.label", 'Role kustom') }}
                                </p>
                            </td>
                            <td class="px-5 py-3">{{ $role->users_count }}</td>
                            <td class="px-5 py-3">{{ $role->permissions_count }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    @can('roles.update')
                                        <a
                                            href="{{ route('admin.roles.edit', $role) }}"
                                            class="inline-flex items-center gap-1 rounded-lg border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700"
                                        >
                                            <x-icon name="pencil" class="h-4 w-4" />
                                            Ubah
                                        </a>
                                    @endcan

                                    @can('roles.delete')
                                        @unless ($isLocked)
                                            <button
                                                type="button"
                                                data-modal-target="delete-role-{{ $role->id }}"
                                                data-modal-toggle="delete-role-{{ $role->id }}"
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
                                Belum ada role.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    @can('roles.delete')
        @foreach ($roles as $role)
            @unless (config("rbac.roles.{$role->name}.locked", false))
                <x-confirm-delete-modal
                    :id="'delete-role-'.$role->id"
                    :action="route('admin.roles.destroy', $role)"
                    title="Hapus role?"
                    :description="'Role '.$role->name.' akan dihapus permanen. Role yang masih dipakai pengguna tidak dapat dihapus.'"
                />
            @endunless
        @endforeach
    @endcan
@endpush
