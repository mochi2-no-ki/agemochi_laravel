<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageTypeSeeder extends Seeder
{
    public function run(): void
    {
        $messageTypes = config('constants.MESSAGE_TYPE');

        DB::table('message_type')->insert([
            [
                'message_type_id' => $messageTypes['NORMAL'],
                'message_type' => 'normal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'message_type_id' => $messageTypes['GREETING'],
                'message_type' => 'greeting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'message_type_id' => $messageTypes['ANNOUNCE'],
                'message_type' => 'announce',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'message_type_id' => $messageTypes['QUESTION'],
                'message_type' => 'question',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'message_type_id' => $messageTypes['REPLY'],
                'message_type' => 'reply',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
