<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealtimeStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('realtime_status')->insert([
            [
                'realtime_status_id' => '001',
                'realtime_status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'realtime_status_id' => '002',
                'realtime_status' => 'ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'realtime_status_id' => '003',
                'realtime_status' => 'ended',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
