<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('message_type')->insert([
            [
                'message_type_id' => '001',
                'message_type' => 'normal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'message_type_id' => '002',
                'message_type' => 'opening',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'message_type_id' => '003',
                'message_type' => 'announce',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'message_type_id' => '004',
                'message_type' => 'reply',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'message_type_id' => '005',
                'message_type' => 'question',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'message_type_id' => '006',
                'message_type' => 'closing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
