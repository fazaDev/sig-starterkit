<?php

use App\Models\User;

test('guests can see the login page', function () {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee('Masuk ke Panel Admin');
});

test('guests can see the password reset pages', function () {
    $this->get(route('password.request'))
        ->assertOk()
        ->assertSee('Lupa Password');

    $this->get(route('password.reset', ['token' => 'dummy-token', 'email' => 'user@example.com']))
        ->assertOk()
        ->assertSee('Buat Password Baru');
});

test('users can login with valid credentials', function () {
    $user = User::factory()->create();

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($user);
});

test('users cannot login with an invalid password', function () {
    $user = User::factory()->create();

    $this->from(route('login'))
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('authenticated users can logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});

test('public registration is disabled', function () {
    $this->get('/register')->assertNotFound();
});
