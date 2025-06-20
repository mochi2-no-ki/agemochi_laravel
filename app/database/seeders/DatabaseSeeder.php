<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // あげモチ用のマスタデータSeederを呼び出す
        $this->call([
            RealtimeStatusSeeder::class,
            MessageTypeSeeder::class,
        ]);
    }
}
