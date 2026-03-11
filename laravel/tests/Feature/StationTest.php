<?php

use App\Models\Station;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('search filters stations by city', function () {
    $user = User::factory()->create();

    Station::factory()->create([
        'city' => 'Rabat',
        'is_available' => true
    ]);

    Station::factory()->create([
        'city' => 'Casablanca',
        'is_available' => true
    ]);
    
    Sanctum::actingAs($user);

    $response = $this->getJson('/api/stations?city=Rabat');

    $response->assertStatus(200)->assertJsonCount(1);

});