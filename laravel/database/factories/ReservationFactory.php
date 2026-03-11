<?php

namespace Database\Factories;

use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'station_id' => Station::factory(),
            'start_time' => now()->addHour(),
            'end_time' => now()->addHour(2),
            'energy_kwh' => fake()->randomFloat(2, 5, 80),
            'status' => 'reserved',
        ];
    }
}
