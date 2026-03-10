<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stations')->insert([
            [
                'name' => 'Marrakech EV Station',
                'city' => 'Marrakesh',
                'location' => 'Gueliz',
                'power' => 50,
                'is_available' => true,
                'connector_type_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Menara Charging Point',
                'city' => 'Marrakesh',
                'location' => 'Menara Mall',
                'power' => 120,
                'is_available' => true,
                'connector_type_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Airport Fast Charge',
                'city' => 'Marrakesh',
                'location' => 'Marrakech Airport',
                'power' => 150,
                'is_available' => false,
                'connector_type_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'City Center Charger',
                'city' => 'Rabat',
                'location' => 'Rabat center',
                'power' => 22,
                'is_available' => true,
                'connector_type_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
