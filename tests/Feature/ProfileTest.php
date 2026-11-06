<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('guests cannot view the profile page', function () {
    $this->get(route('profile.edit'))->assertRedirect(route('login'));
});

test('users can view the profile page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('Profil Saya');
});

test('users can update their profile information', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('user-profile-information.update'), [
            'name' => 'Nama Terbaru',
            'email' => 'terbaru@example.com',
        ])
        ->assertSessionHas('status', 'profile-information-updated');

    $user->refresh();

    expect($user->name)->toBe('Nama Terbaru')
        ->and($user->email)->toBe('terbaru@example.com');
});

test('users can update their password', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('user-password.update'), [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertSessionHas('status', 'password-updated');

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('users cannot update their password with a wrong current password', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('profile.edit'))
        ->put(route('user-password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertRedirect(route('profile.edit'))
        ->assertSessionHasErrorsIn('updatePassword', ['current_password']);

    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
});
