@php
    $isEdit = isset($role) && $role;
    $selectedPermissions = old('permissions', $rolePermissions ?? []);
    $locked = $isEdit && ($isLocked ?? false);
@endphp

<div class="space-y-5">
    <div>
        <x-label for="name">Nama Role</x-label>
        <x-input
            name="name"
            :value="old('name', $isEdit ? $role->name : '')"
            :disabled="$locked"
            required
            autofocus
            placeholder="mis. supervisor"
        />
        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
            Gunakan huruf, angka, tanda hubung, atau garis bawah.
        </p>
        <x-input-error :messages="$errors->get('name')" />
    </div>

    <div>
        <p class="mb-3 block text-sm font-medium text-gray-900 dark:text-white">Permission</p>

        <div class="space-y-4">
            @foreach ($permissionGroups as $groupLabel => $permissions)
                <fieldset class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                    <legend class="px-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $groupLabel }}</legend>

                    <div class="mt-2 grid gap-2 sm:grid-cols-2">
                        @foreach ($permissions as $permissionName => $permission)
                            <label class="flex items-start gap-3 rounded-lg p-2 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permissionName }}"
                                    class="mt-0.5 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                    @checked(in_array($permissionName, $selectedPermissions, true))
                                    @disabled($locked)
                                >
                                <span>
                                    <span class="block text-sm text-gray-900 dark:text-white">{{ $permission['label'] }}</span>
                                    <span class="block font-mono text-xs text-gray-400 dark:text-gray-500">{{ $permissionName }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
            @endforeach
        </div>

        <x-input-error :messages="$errors->get('permissions')" />
        <x-input-error :messages="$errors->get('permissions.*')" />

        @if ($locked)
            <x-alert type="warning" class="mt-4">
                Role admin bersifat permanen: nama dan permission-nya tidak dapat diubah dari panel.
            </x-alert>
        @endif
    </div>
</div>
