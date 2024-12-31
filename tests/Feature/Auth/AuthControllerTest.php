<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('can register a user', function () {
    $response = $this->postJson(route('api.auth.register'), [
        'name' => 'Test User',
        'email' => 'test1@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'email' => 'test1@example.com',
    ]);
});

it('can login a user', function () {
    $user = \App\Models\User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson(route('api.auth.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200);
    $this->assertAuthenticatedAs($user);
});

it('cannot register a user with invalid input', function () {
    $response = $this->postJson(route('api.auth.register'), [
        'name' => '',
        'email' => 'invalid-email',
        'password' => 'short',
        'password_confirmation' => 'different',
    ]);

    $response->assertStatus(422)->assertJsonValidationErrors(['name', 'email', 'password']);
});

it('cannot login a user with invalid credentials', function () {
    $user = \App\Models\User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson(route('api.auth.login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(401);
});

it('can logout a user', function () {
    $user = \App\Models\User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    // Create a real token for the user
    $token = $user->createToken('TestToken')->plainTextToken;

    // Assert that the token exists in the database
    $this->assertDatabaseHas('personal_access_tokens', [
        'tokenable_id' => $user->id,
    ]);

    // Use the token to authenticate the logout request
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->post(route('api.auth.logout'));

    $response->assertOk();
    // Assert that the token is deleted from the database
    $this->assertDatabaseMissing('personal_access_tokens', [
        'tokenable_id' => $user->id,
    ]);
});
