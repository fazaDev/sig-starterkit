<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('users without the view permission cannot access role management', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.roles.index'))
        ->assertForbidden();
});

test('an admin can create a role with permissions', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $this->actingAs($admin)
        ->post(route('admin.roles.store'), [
            'name' => 'supervisor',
            'permissions' => ['dashboard.view', 'users.view'],
        ])
        ->assertRedirect(route('admin.roles.index'));

    $role = Role::findByName('supervisor', 'web');

    expect($role->hasPermissionTo('dashboard.view'))->toBeTrue()
        ->and($role->hasPermissionTo('users.view'))->toBeTrue()
        ->and($role->hasPermissionTo('users.delete'))->toBeFalse();
});

test('an admin can update a role and its permissions', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $role = Role::create(['name' => 'supervisor', 'guard_name' => 'web']);
    $role->givePermissionTo('dashboard.view');

    $this->actingAs($admin)
        ->put(route('admin.roles.update', $role), [
            'name' => 'koordinator',
            'permissions' => ['dashboard.view', 'users.view'],
        ])
        ->assertRedirect(route('admin.roles.index'));

    $role->refresh();

    expect($role->name)->toBe('koordinator')
        ->and($role->hasPermissionTo('users.view'))->toBeTrue();
});

test('an admin can view the role create and edit forms', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $this->actingAs($admin)
        ->get(route('admin.roles.create'))
        ->assertOk()
        ->assertSee('Tambah Role');

    $this->actingAs($admin)
        ->get(route('admin.roles.edit', Role::findByName('admin', 'web')))
        ->assertOk()
        ->assertSee('Role admin bersifat permanen');
});

test('the locked admin role cannot be updated', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $role = Role::findByName('admin', 'web');
    $permissionCount = $role->permissions()->count();

    $this->actingAs($admin)
        ->put(route('admin.roles.update', $role), [
            'name' => 'admin',
            'permissions' => ['dashboard.view'],
        ])
        ->assertSessionHas('error');

    expect($role->permissions()->count())->toBe($permissionCount);
});

test('a role that is in use cannot be deleted', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $user = User::factory()->create();
    $user->assignRole('staff');

    $this->actingAs($admin)
        ->delete(route('admin.roles.destroy', Role::findByName('staff', 'web')))
        ->assertSessionHas('error');

    expect(Role::where('name', 'staff')->exists())->toBeTrue();
});

test('an unused role can be deleted', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $role = Role::create(['name' => 'sementara', 'guard_name' => 'web']);

    $this->actingAs($admin)
        ->delete(route('admin.roles.destroy', $role))
        ->assertRedirect(route('admin.roles.index'));

    $this->assertModelMissing($role);
});

test('the locked admin role cannot be deleted', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $this->actingAs($admin)
        ->delete(route('admin.roles.destroy', Role::findByName('admin', 'web')))
        ->assertSessionHas('error');

    expect(Role::where('name', 'admin')->exists())->toBeTrue();
});
