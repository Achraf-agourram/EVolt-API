<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reservations')->insert([
            [
                'user_id' => 1,
                'station_id' => 1,
                'start_time' => Carbon::now()->addHour(),
                'end_time' => Carbon::now()->addHours(2),
                'energy_kwh' => null,
                'status' => 'reserved',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'station_id' => 2,
                'start_time' => Carbon::now()->subHours(2),
                'end_time' => Carbon::now()->subHour(),
                'energy_kwh' => 12.5,
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'station_id' => 1,
                'start_time' => Carbon::now()->addHours(3),
                'end_time' => Carbon::now()->addHours(4),
                'energy_kwh' => null,
                'status' => 'reserved',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'station_id' => 3,
                'start_time' => Carbon::now()->subHour(),
                'end_time' => Carbon::now()->addHour(),
                'energy_kwh' => null,
                'status' => 'charging',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'station_id' => 2,
                'start_time' => Carbon::now()->addDay(),
                'end_time' => Carbon::now()->addDay()->addHour(),
                'energy_kwh' => null,
                'status' => 'reserved',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
