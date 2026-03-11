<?php

use App\Models\Station;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('user can book', function () {

    $user = User::factory()->create();

    $station = Station::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->postJson('/api/book', [
        'station_id' => $station->id,
        'start_time' => now()->addHour(),
        'end_time' => now()->addHours(2),
    ]);

    $response->assertStatus(201);

});