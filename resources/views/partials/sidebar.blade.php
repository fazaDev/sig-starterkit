<aside
    id="app-sidebar"
    class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white transition-transform lg:translate-x-0 dark:border-gray-700 dark:bg-gray-800"
    aria-label="Navigasi utama"
>
    <div class="flex h-full flex-col px-3 py-4">
        <a href="{{ route('dashboard') }}" class="mb-6 flex items-center gap-3 px-2">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-700 text-sm font-bold text-white">
                {{ mb_strtoupper(mb_substr(config('app.name'), 0, 1)) }}
            </span>
            <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
        </a>

        <nav class="flex-1 space-y-1">
            @can('dashboard.view')
                <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="dashboard">
                    Dashboard
                </x-sidebar-link>
            @endcan

            @can('users.view')
                <x-sidebar-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" icon="users">
                    Pengguna
                </x-sidebar-link>
            @endcan

            @can('roles.view')
                <x-sidebar-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')" icon="shield">
                    Role &amp; Permission
                </x-sidebar-link>
            @endcan
        </nav>

        <div class="mt-4 space-y-1 border-t border-gray-200 pt-4 dark:border-gray-700">
            <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')" icon="user">
                Profil Saya
            </x-sidebar-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white"
                >
                    <x-icon name="logout" class="h-5 w-5 shrink-0" />
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
</aside>
