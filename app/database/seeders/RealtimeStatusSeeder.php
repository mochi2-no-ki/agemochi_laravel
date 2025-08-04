<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealtimeStatusSeeder extends Seeder
{
    public function run(): void
    {
        $realtimeStatuses = config('constants.REALTIME_STATUS');

        DB::table('realtime_status')->insert([
            [
                'realtime_status_id' => $realtimeStatuses['SCHEDULED'],
                'realtime_status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'realtime_status_id' => $realtimeStatuses['HOLDING'],
                'realtime_status' => 'holding',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'realtime_status_id' => $realtimeStatuses['ENDED'],
                'realtime_status' => 'ended',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
