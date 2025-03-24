<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add a few sample conferences
        DB::table('conferences')->insert([
            [
                'year' => 2023,
                'name' => 'DevCon 2023',
                'start_date' => '2023-06-15',
                'end_date' => '2023-06-18',
                'location' => 'University of Zagreb',
                'description' => 'Annual developer conference for 2023',
                'is_active' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'year' => 2024,
                'name' => 'DevCon 2024',
                'start_date' => '2024-06-20',
                'end_date' => '2024-06-23',
                'location' => 'University of Ljubljana',
                'description' => 'Annual developer conference for 2024',
                'is_active' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'year' => 2025,
                'name' => 'DevCon 2025',
                'start_date' => '2025-06-15',
                'end_date' => '2025-06-18',
                'location' => 'Slovak University of Agriculture in Nitra',
                'description' => 'Annual developer conference for 2025',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
