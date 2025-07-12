<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->withoutExceptionHandling();
    \Illuminate\Support\Facades\Artisan::call('passport:client --personal --no-interaction');
});

it('can register a user', function () {
    $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => '!passworD123',
        'password_confirmation' => '!passworD123',
    ])->assertStatus(201)->assertJsonStructure([
        'token',
        'message'
   ]);
});

it('can login', function () {
    $user = User::factory()->create();
    // default password for UserFactory is 'password'

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertStatus(200)->assertJsonStructure([
        'token',
        'message'
    ]);
});

it('can logout', function () {
    $user = User::factory()->create();
    Auth::login($user, true);

    $this->postJson('/api/logout')
        ->assertStatus(200)
        ->assertJson(['message' => 'Successfully logged out.']);
});
