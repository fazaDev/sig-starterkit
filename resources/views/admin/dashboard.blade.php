@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-page-header title="Dashboard" description="Ringkasan data pengguna dan role pada aplikasi." />

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalUsers }}</p>
                </div>
                <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-50 text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                    <x-icon name="users" class="h-6 w-6" />
                </span>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Role</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalRoles }}</p>
                </div>
                <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-50 text-purple-700 dark:bg-purple-900 dark:text-purple-300">
                    <x-icon name="shield" class="h-6 w-6" />
                </span>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:col-span-2 xl:col-span-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengguna Baru Bulan Ini</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $newUsersThisMonth }}</p>
                </div>
                <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-50 text-green-700 dark:bg-green-900 dark:text-green-300">
                    <x-icon name="plus" class="h-6 w-6" />
                </span>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800 lg:col-span-2">
            <header class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Pengguna Terbaru</h2>
            </header>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-5 py-3">Nama</th>
                            <th scope="col" class="px-5 py-3">Role</th>
                            <th scope="col" class="px-5 py-3">Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestUsers as $user)
                            <tr class="border-b border-gray-200 last:border-0 dark:border-gray-700">
                                <td class="px-5 py-3">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada pengguna.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <header class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Pengguna per Role</h2>
            </header>

            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($usersByRole as $role)
                    <li class="flex items-center justify-between px-5 py-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ config("rbac.roles.{$role->name}.label", 'Role kustom') }}
                            </p>
                        </div>
                        <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                            {{ $role->users_count }} pengguna
                        </span>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                        Belum ada role.
                    </li>
                @endforelse
            </ul>
        </section>
    </div>
@endsection
