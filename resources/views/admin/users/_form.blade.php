@php
    $isEdit = isset($user) && $user;
    $selectedRoles = old('roles', $isEdit ? $user->roles->pluck('name')->all() : []);
@endphp

<div class="space-y-5">
    <div>
        <x-label for="name">Nama</x-label>
        <x-input name="name" :value="old('name', $isEdit ? $user->name : '')" required autofocus autocomplete="name" placeholder="Nama lengkap" />
        <x-input-error :messages="$errors->get('name')" />
    </div>

    <div>
        <x-label for="email">Email</x-label>
        <x-input name="email" type="email" :value="old('email', $isEdit ? $user->email : '')" required autocomplete="email" placeholder="nama@perusahaan.com" />
        <x-input-error :messages="$errors->get('email')" />
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <x-label for="password">
                Password
                @if ($isEdit)
                    <span class="font-normal text-gray-500 dark:text-gray-400">(kosongkan jika tidak diubah)</span>
                @endif
            </x-label>
            <x-input
                name="password"
                type="password"
                :required="! $isEdit"
                autocomplete="new-password"
                placeholder="Minimal 8 karakter"
            />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-label for="password_confirmation">Konfirmasi Password</x-label>
            <x-input
                name="password_confirmation"
                type="password"
                :required="! $isEdit"
                autocomplete="new-password"
                placeholder="Ulangi password"
            />
        </div>
    </div>

    <div>
        <p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Role</p>

        <div class="grid gap-2 sm:grid-cols-2">
            @foreach ($roles as $role)
                <label class="flex items-start gap-3 rounded-lg border border-gray-200 p-3 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700">
                    <input
                        type="checkbox"
                        name="roles[]"
                        value="{{ $role->name }}"
                        class="mt-0.5 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                        @checked(in_array($role->name, $selectedRoles, true))
                    >
                    <span>
                        <span class="block text-sm font-medium text-gray-900 dark:text-white">{{ $role->name }}</span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400">
                            {{ config("rbac.roles.{$role->name}.description", 'Role kustom') }}
                        </span>
                    </span>
                </label>
            @endforeach
        </div>

        <x-input-error :messages="$errors->get('roles')" />
        <x-input-error :messages="$errors->get('roles.*')" />
    </div>
</div>
