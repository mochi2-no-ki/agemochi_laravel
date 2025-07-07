<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestChatUserSeeder extends Seeder
{
    public function run(): void
    {
        $userAId = (string) Str::uuid();
        $userBId = (string) Str::uuid();
        $userCId = (string) Str::uuid();

        DB::table('user_account')->insert([
            [
                'user_id' => $userAId,
                'mochi_id' => 'testuserA',
                'user_name' => 'チャットユーザーA',
                'user_img_path' => null,
                'current_user_banner_id' => null,
                'current_icon_frame_id' => null,
                'introduction' => 'こんにちは、Aです！',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userBId,
                'mochi_id' => 'testuserB',
                'user_name' => 'チャットユーザーB',
                'user_img_path' => null,
                'current_user_banner_id' => null,
                'current_icon_frame_id' => null,
                'introduction' => 'こんにちは、Bです！',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userCId,
                'mochi_id' => 'testuserC',
                'user_name' => 'チャットユーザーC',
                'user_img_path' => null,
                'current_user_banner_id' => null,
                'current_icon_frame_id' => null,
                'introduction' => 'こんにちは、Cです！',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('user_login')->insert([
            [
                'user_id' => $userAId,
                'mail' => 'a@chat.com',
                'password' => Hash::make('pass'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userBId,
                'mail' => 'b@chat.com',
                'password' => Hash::make('pass'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userCId,
                'mail' => 'c@chat.com',
                'password' => Hash::make('pass'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('user_save')->insert([
            [
                'user_id' => $userAId,
                'routine_save_max' => 30,
                'realtime_routine_save_max' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userBId,
                'routine_save_max' => 30,
                'realtime_routine_save_max' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userCId,
                'routine_save_max' => 30,
                'realtime_routine_save_max' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
