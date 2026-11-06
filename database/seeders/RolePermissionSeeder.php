<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed the application's roles and permissions.
     */
    public function run(): void
    {
        $permissions = array_keys(config('rbac.permissions'));

        $registrar = app(PermissionRegistrar::class);
        $registrar->forgetCachedPermissions();

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // The registrar caches permissions on first access, so refresh the
        // cache before resolving permissions by name while syncing roles.
        $registrar->forgetCachedPermissions();

        $permissionModels = Permission::query()
            ->whereIn('name', $permissions)
            ->where('guard_name', 'web')
            ->get();

        foreach (config('rbac.roles') as $name => $definition) {
            $role = Role::findOrCreate($name, 'web');

            $role->syncPermissions(
                $definition['permissions'] === '*'
                    ? $permissionModels
                    : $permissionModels->whereIn('name', $definition['permissions'])
            );
        }

        $registrar->forgetCachedPermissions();
    }
}
