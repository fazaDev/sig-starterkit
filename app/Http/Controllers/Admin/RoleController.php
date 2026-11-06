<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index(): View
    {
        return view('admin.roles.index', [
            'roles' => Role::query()->withCount(['users', 'permissions'])->orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        return view('admin.roles.create', [
            'permissionGroups' => $this->permissionGroups(),
        ]);
    }

    /**
     * Store a newly created role.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create([
            'name' => $request->validated('name'),
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($request->validated('permissions', []));

        return redirect()
            ->route('admin.roles.index')
            ->with('status', 'Role berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the given role.
     */
    public function edit(Role $role): View
    {
        return view('admin.roles.edit', [
            'role' => $role->load('permissions'),
            'permissionGroups' => $this->permissionGroups(),
            'rolePermissions' => $role->permissions->pluck('name')->all(),
            'isLocked' => $this->isLocked($role),
        ]);
    }

    /**
     * Update the given role.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        if ($this->isLocked($role)) {
            return back()->with('error', 'Role admin bersifat permanen dan tidak dapat diubah.');
        }

        $role->update(['name' => $request->validated('name')]);
        $role->syncPermissions($request->validated('permissions', []));

        return redirect()
            ->route('admin.roles.index')
            ->with('status', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the given role.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if ($this->isLocked($role)) {
            return back()->with('error', 'Role admin bersifat permanen dan tidak dapat dihapus.');
        }

        if ($role->users()->exists()) {
            return back()->with('error', 'Role masih digunakan oleh pengguna sehingga tidak dapat dihapus.');
        }

        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('status', 'Role berhasil dihapus.');
    }

    /**
     * Group the configured permissions by their display group.
     *
     * @return array<string, array<string, array{group: string, label: string}>>
     */
    private function permissionGroups(): array
    {
        $groups = [];

        foreach (config('rbac.groups') as $key => $label) {
            $permissions = array_filter(
                config('rbac.permissions'),
                fn (array $permission): bool => $permission['group'] === $key,
            );

            if ($permissions !== []) {
                $groups[$label] = $permissions;
            }
        }

        return $groups;
    }

    /**
     * Determine whether the given role is locked by configuration.
     */
    private function isLocked(Role $role): bool
    {
        return (bool) config("rbac.roles.{$role->name}.locked", false);
    }
}
