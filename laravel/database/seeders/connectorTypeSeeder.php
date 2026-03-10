<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class connectorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('connector_types')->insert([
            ['name' => 'Type 1 (SAE J1772)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Type 2 (Mennekes)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CCS1 (Combined Charging System)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CCS2 (Combined Charging System)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CHAdeMO', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tesla Supercharger', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
