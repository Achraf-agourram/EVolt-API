<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

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