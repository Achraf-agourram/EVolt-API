<?php

use App\Models\Reservation;
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

test('user cancel booking', function () {

    $user = User::factory()->create();

    $reservation = Reservation::factory()->create([
        'user_id' => $user->id
    ]);

    Sanctum::actingAs($user);

    $response = $this->patchJson("/api/reservations/{$reservation->id}/cancel");

    $response->assertStatus(200)->assertJson(['message' => 'Reservation cancelled successfully']);;

});

test('user can update booking', function () {

    $user = User::factory()->create();

    $reservation = Reservation::factory()->create([
        'user_id' => $user->id
    ]);

    Sanctum::actingAs($user);

    $response = $this->putJson("/api/reservations/{$reservation->id}", [
        'start_time' => now()->addHours(3),
        'end_time' => now()->addHours(4),
    ]);

    $response->assertStatus(200)->assertJson(['message' => 'Reservation updated successfully']);

});

test('user can view reservation history', function () {

    $user = User::factory()->create();

    Reservation::factory()->count(3)->create([
        'user_id' => $user->id,
        'status' => 'completed'
    ]);

    Sanctum::actingAs($user);

    $response = $this->getJson('/api/history');

    $response->assertStatus(200)->assertJsonCount(3);
});