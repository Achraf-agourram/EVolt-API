<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('user can register', function () {

    $response = $this->postJson('/api/register', [
        'name' => 'anas',
        'email' => 'test@test.com',
        'password' => '12345678',
        'role' => 'client'
    ]);

    $response->assertStatus(201);

});


test('user can login', function () {

    User::create([
        'name' => 'anas',
        'email' => 'test@test.com',
        'password' => '12345678',
        'role' => 'client'
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@test.com',
        'password' => '12345678'
    ]);

    $response->assertStatus(200);

});

test('user can logout', function () {

    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->postJson('/api/logout');

    $response->assertStatus(200)->assertJson(['message' => 'Logged out']);

});