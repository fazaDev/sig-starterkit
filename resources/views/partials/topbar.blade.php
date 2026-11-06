@php
    $user = auth()->user();
    $primaryRole = $user->roles->first();
@endphp

<header class="sticky top-0 z-30 border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
    <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button
                type="button"
                class="inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 lg:hidden dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                data-drawer-target="app-sidebar"
                data-drawer-toggle="app-sidebar"
                aria-controls="app-sidebar"
            >
                <x-icon name="menu" />
                <span class="sr-only">Buka navigasi</span>
            </button>

            <span class="hidden text-sm font-medium text-gray-500 sm:inline dark:text-gray-400">Panel Admin</span>
        </div>

        <div class="flex items-center gap-2">
            <button
                type="button"
                class="inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                data-theme-toggle
            >
                <x-icon name="moon" data-theme-toggle-icon="moon" />
                <x-icon name="sun" class="hidden" data-theme-toggle-icon="sun" />
                <span class="sr-only">Ubah tema</span>
            </button>

            <button
                type="button"
                class="flex items-center gap-3 rounded-lg p-2 text-left hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                data-dropdown-toggle="user-menu"
                data-dropdown-placement="bottom-end"
            >
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-700 text-sm font-semibold text-white">
                    {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                </span>

                <span class="hidden sm:block">
                    <span class="block text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</span>
                    <span class="block text-xs text-gray-500 dark:text-gray-400">
                        {{ $primaryRole?->name ?? 'Tanpa role' }}
                    </span>
                </span>
            </button>

            <div
                id="user-menu"
                class="z-50 hidden w-56 rounded-lg border border-gray-200 bg-white py-2 shadow-lg dark:border-gray-700 dark:bg-gray-800"
            >
                <div class="px-4 py-2">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                </div>

                <div class="my-1 border-t border-gray-200 dark:border-gray-700"></div>

                <a
                    href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    <x-icon name="user" class="h-4 w-4" />
                    Profil Saya
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-700"
                    >
                        <x-icon name="logout" class="h-4 w-4" />
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
