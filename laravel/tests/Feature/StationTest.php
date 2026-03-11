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

test('admin can update station', function () {
    $user = User::factory()->create(['role' => 'admin']);
    Sanctum::actingAs($user);

    $station = Station::factory()->create();

    $data = [
        'name' => 'FastCharge Station',
        'city' => 'Rabat',
        'location' => 'centre',
        'power' => 50,
        'is_available' => false
    ];

    $response = $this->patchJson("/api/station/{$station->id}", $data);

    $response->assertStatus(200)->assertJson(['message' => 'Station updated successfully']);

});

test('client cannot update station', function () {
    $user = User::factory()->create(['role' => 'client']);
    Sanctum::actingAs($user);

    $station = Station::factory()->create();

    $data = [
        'name' => 'FastCharge Station',
        'city' => 'Rabat',
        'location' => 'centre',
        'power' => 50,
        'is_available' => false
    ];

    $response = $this->patchJson("/api/station/{$station->id}", $data);

    $response->assertStatus(403);

});

test('admin can delete station with no reservations', function () {

    $admin = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($admin);

    $station = Station::factory()->create();

    $response = $this->deleteJson("/api/station/{$station->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('stations', [
        'id' => $station->id
    ]);

});

test('cannot delete station with active reservations', function () {

    $admin = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($admin);

    $station = Station::factory()->create();

    Reservation::factory()->create([
        'station_id' => $station->id,
        'status' => 'reserved'
    ]);

    $response = $this->deleteJson("/api/station/{$station->id}");

    $response->assertStatus(400);

});

test('client cannot delete station', function () {

    $client = User::factory()->create(['role' => 'client']);

    Sanctum::actingAs($client);

    $station = Station::factory()->create();

    $response = $this->deleteJson("/api/station/{$station->id}");

    $response->assertStatus(403);

});