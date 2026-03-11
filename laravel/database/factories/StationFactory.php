<?php

namespace Database\Factories;

use App\Models\ConnectorType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Station>
 */
class StationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Station',
            'city' => fake()->city(),
            'location' => fake()->address(),
            'connector_type_id' => ConnectorType::factory(),
            'power' => fake()->numberBetween(20,150),
            'is_available' => true
        ];
    }
}
