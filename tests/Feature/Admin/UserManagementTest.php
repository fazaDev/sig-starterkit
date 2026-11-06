<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('guests cannot access user management', function () {
    $this->get(route('admin.users.index'))->assertRedirect(route('login'));
});

test('users without the view permission cannot access user management', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.users.index'))
        ->assertForbidden();
});

test('an admin can create a user with a role', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'name' => 'Staff Baru',
            'email' => 'staff@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'roles' => ['staff'],
        ])
        ->assertRedirect(route('admin.users.index'));

    $user = User::query()->where('email', 'staff@example.com')->firstOrFail();

    expect($user->name)->toBe('Staff Baru')
        ->and($user->hasRole('staff'))->toBeTrue()
        ->and(Hash::check('password', $user->password))->toBeTrue();
});

test('an admin can update a user and its roles', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $user = User::factory()->create();
    $user->assignRole('staff');

    $this->actingAs($admin)
        ->put(route('admin.users.update', $user), [
            'name' => 'Nama Diperbarui',
            'email' => 'diperbarui@example.com',
            'password' => '',
            'password_confirmation' => '',
            'roles' => ['admin'],
        ])
        ->assertRedirect(route('admin.users.index'));

    $user->refresh();

    expect($user->name)->toBe('Nama Diperbarui')
        ->and($user->email)->toBe('diperbarui@example.com')
        ->and($user->hasRole('admin'))->toBeTrue()
        ->and($user->hasRole('staff'))->toBeFalse();
});

test('an admin can view the user create and edit forms', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $user = User::factory()->create();
    $user->assignRole('staff');

    $this->actingAs($admin)
        ->get(route('admin.users.create'))
        ->assertOk()
        ->assertSee('Tambah Pengguna');

    $this->actingAs($admin)
        ->get(route('admin.users.edit', $user))
        ->assertOk()
        ->assertSee($user->name);
});

test('an admin cannot delete their own account', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $admin))
        ->assertSessionHas('error');

    $this->assertModelExists($admin);
});

test('an admin can delete another user', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $user = User::factory()->create();
    $user->assignRole('staff');

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $user))
        ->assertRedirect(route('admin.users.index'));

    $this->assertModelMissing($user);
});

test('the last admin cannot be deleted by a user with delete permission', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $deleter = User::factory()->create();
    $deleter->givePermissionTo('users.delete');

    $this->actingAs($deleter)
        ->delete(route('admin.users.destroy', $admin))
        ->assertSessionHas('error');

    $this->assertModelExists($admin);
});

test('a user must have at least one role', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'name' => 'Tanpa Role',
            'email' => 'tanpa-role@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'roles' => [],
        ])
        ->assertSessionHasErrors('roles');

    $this->assertDatabaseMissing('users', ['email' => 'tanpa-role@example.com']);
});

test('role names are available through the role model used by the panel', function () {
    expect(Role::query()->orderBy('name')->pluck('name')->all())->toBe(['admin', 'staff']);
});
