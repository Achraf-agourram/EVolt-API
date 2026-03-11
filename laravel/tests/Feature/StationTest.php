<?php

use App\Models\ConnectorType;
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

test('search filters stations by location', function () {
    $user = User::factory()->create();

    Station::factory()->create([
        'location' => 'Downtown',
        'is_available' => true
    ]);

    Station::factory()->create([
        'location' => 'Airport',
        'is_available' => true
    ]);

    Sanctum::actingAs($user);
    $response = $this->getJson('/api/stations?location=Downtown');

    $response->assertStatus(200)->assertJsonCount(1);

});

test('search filters by city and location', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    Station::factory()->create([
        'city' => 'Rabat',
        'location' => 'Center',
        'is_available' => true
    ]);

    Station::factory()->create([
        'city' => 'Rabat',
        'location' => 'Airport',
        'is_available' => true
    ]);

    $response = $this->getJson('/api/stations?city=Rabat&location=Center');

    $response->assertStatus(200)->assertJsonCount(1);

});

test('admin can create station', function () {
    $user = User::factory()->create(['role' => 'admin']);
    Sanctum::actingAs($user);

    $connectorType = ConnectorType::factory()->create();

    $data = [
        'name' => 'FastCharge Station',
        'city' => 'Rabat',
        'location' => 'centre',
        'connector_type_id' => $connectorType->id,
        'power' => 50,
        'is_available' => true
    ];

    $response = $this->postJson('/api/station', $data);

    $response->assertStatus(201);

    $this->assertDatabaseHas('stations', [
        'name' => 'FastCharge Station',
        'city' => 'Rabat'
    ]);

});

test('client cannot create station', function () {
    $user = User::factory()->create(['role' => 'client']);
    Sanctum::actingAs($user);

    $connectorType = ConnectorType::factory()->create();

    $data = [
        'name' => 'FastCharge Station',
        'city' => 'Rabat',
        'location' => 'centre',
        'connector_type_id' => $connectorType->id,
        'power' => 50,
        'is_available' => true
    ];

    $response = $this->postJson('/api/station', $data);

    $response->assertStatus(403);
});