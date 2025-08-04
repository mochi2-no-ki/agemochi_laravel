<?php

namespace Database\Seeders;

use App\Services\Support\UuidService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('message')->delete();
        DB::table('message_type')->delete();
        DB::table('realtime_routine_participant')->delete();
        DB::table('realtime_routine')->delete();
        DB::table('realtime_status')->delete();
        DB::table('realtime_routine_save')->delete();
        DB::table('routine_save')->delete();
        DB::table('routine_view')->delete();
        DB::table('routine_tag')->delete();
        DB::table('routine')->delete();
        DB::table('tag')->delete();
        DB::table('user_save')->delete();
        DB::table('user_login')->delete();
        DB::table('user_account')->delete();

        // ユーザーアカウント（user_account）2件
        $user1Id = UuidService::generateV7();
        $user2Id = UuidService::generateV7();

        DB::table('user_account')->insert([
            [
                'user_id' => $user1Id,
                'mochi_id' => 'testuser001',
                'user_name' => 'テストユーザー1',
                'user_img_path' => null,
                'current_user_banner_id' => null,
                'current_icon_frame_id' => null,
                'introduction' => 'こんにちは！',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user2Id,
                'mochi_id' => 'testuser002',
                'user_name' => 'テストユーザー2',
                'user_img_path' => null,
                'current_user_banner_id' => null,
                'current_icon_frame_id' => null,
                'introduction' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ログイン情報（user_login）
        DB::table('user_login')->insert([
            [
                'user_id' => $user1Id,
                'mail' => 'test1@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user2Id,
                'mail' => 'test2@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 保存情報（user_save）
        DB::table('user_save')->insert([
            [
                'user_id' => $user1Id,
                'routine_save_max' => 30,
                'realtime_routine_save_max' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user2Id,
                'routine_save_max' => 30,
                'realtime_routine_save_max' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // タグ（tag）
        $tagIds = [];
        foreach (['朝活', '夜ルーティーン', '勉強', '運動', 'リラックス'] as $name) {
            $tagId = UuidService::generateV7();
            $tagIds[] = $tagId;

            DB::table('tag')->insert([
                'tag_id' => $tagId,
                'tag_name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]);
        }

        // ルーティーン（routine）2件
        $routine1Id = UuidService::generateV7();
        $routine2Id = UuidService::generateV7();

        DB::table('routine')->insert([
            [
                'routine_id' => $routine1Id,
                'user_id' => $user1Id,
                'routine_title' => '朝の準備',
                'routine_time' => 30,
                'routine_start' => '06:30:00',
                'routine_end' => '07:00:00',
                'routine_body' => '朝ごはん・歯磨き・着替え',
                'realtime_routine_flag' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'routine_id' => $routine2Id,
                'user_id' => $user2Id,
                'routine_title' => '夜のルーティーン',
                'routine_time' => 45,
                'routine_start' => '21:00:00',
                'routine_end' => '21:45:00',
                'routine_body' => '読書・ストレッチ・瞑想',
                'realtime_routine_flag' => false,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);

        // routine_tag
        foreach ($tagIds as $tagId) {
            DB::table('routine_tag')->insert([
                [
                    'routine_tag_id' => UuidService::generateV7(),
                    'routine_id' => $routine1Id,
                    'tag_id' => $tagId,
                    'created_at' => now(),
                ],
                [
                    'routine_tag_id' => UuidService::generateV7(),
                    'routine_id' => $routine2Id,
                    'tag_id' => $tagId,
                    'created_at' => now(),
                ],
            ]);
        }

        // 閲覧数（routine_view）
        DB::table('routine_view')->insert([
            [
                'routine_id' => $routine1Id,
                'reference_count' => 10,
                'view_count' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'routine_id' => $routine2Id,
                'reference_count' => 5,
                'view_count' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // routine_save（保存）2件
        DB::table('routine_save')->insert([
            [
                'routine_save_id' => UuidService::generateV7(),
                'user_id' => $user1Id,
                'routine_id' => $routine2Id,
                'created_at' => now(),
            ],
            [
                'routine_save_id' => UuidService::generateV7(),
                'user_id' => $user2Id,
                'routine_id' => $routine1Id,
                'created_at' => now(),
            ],
        ]);

        // realtime_routine_save（リアルタイム保存）2件
        DB::table('realtime_routine_save')->insert([
            [
                'realtime_routine_save_id' => UuidService::generateV7(),
                'user_id' => $user1Id,
                'routine_id' => $routine2Id,
                'created_at' => now(),
            ],
            [
                'realtime_routine_save_id' => UuidService::generateV7(),
                'user_id' => $user2Id,
                'routine_id' => $routine1Id,
                'created_at' => now(),
            ],
        ]);

        // リアルタイムステータス
        $waitingStatusId = UuidService::generateV7();
        DB::table('realtime_status')->insert([
            [
                'realtime_status_id' => $waitingStatusId,
                'realtime_status' => 'waiting',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);

        // リアルタイムルーティーン
        $realtimeRoutine1Id = UuidService::generateV7();
        $realtimeRoutine2Id = UuidService::generateV7();

        DB::table('realtime_routine')->insert([
            [
                'realtime_routine_id' => $realtimeRoutine1Id,
                'routine_id' => $routine1Id,
                'owner_user_id' => $user1Id,
                'realtime_routine_title' => '朝ルーティーンセッション',
                'start_time' => now()->addHour(),
                'end_time' => now()->addHours(2),
                'actual_end_time' => null,
                'realtime_status_id' => $waitingStatusId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'realtime_routine_id' => $realtimeRoutine2Id,
                'routine_id' => $routine2Id,
                'owner_user_id' => $user2Id,
                'realtime_routine_title' => '夜ルーティーンセッション',
                'start_time' => now()->addHours(3),
                'end_time' => now()->addHours(4),
                'actual_end_time' => null,
                'realtime_status_id' => $waitingStatusId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 参加者（realtime_routine_participant）
        DB::table('realtime_routine_participant')->insert([
            [
                'realtime_routine_participant_id' => UuidService::generateV7(),
                'realtime_routine_id' => $realtimeRoutine1Id,
                'user_id' => $user2Id,
                'created_at' => now(),
            ],
            [
                'realtime_routine_participant_id' => UuidService::generateV7(),
                'realtime_routine_id' => $realtimeRoutine2Id,
                'user_id' => $user1Id,
                'created_at' => now(),
            ],
        ]);

        // メッセージタイプ
        $type1Id = UuidService::generateV7();
        $type2Id = UuidService::generateV7();

        DB::table('message_type')->insert([
            [
                'message_type_id' => $type1Id,
                'message_type' => 'opening',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'message_type_id' => $type2Id,
                'message_type' => 'question',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);

        // メッセージ
        DB::table('message')->insert([
            [
                'message_id' => UuidService::generateV7(),
                'realtime_routine_id' => $realtimeRoutine1Id,
                'user_id' => $user1Id,
                'message_type_id' => $type1Id,
                'message_body' => 'おはようございます！',
                'reply_user_id' => null,
                'created_at' => now(),
            ],
            [
                'message_id' => UuidService::generateV7(),
                'realtime_routine_id' => $realtimeRoutine1Id,
                'user_id' => $user2Id,
                'message_type_id' => $type2Id,
                'message_body' => '質問があります',
                'reply_user_id' => $user1Id,
                'created_at' => now(),
            ],
        ]);
    }
}
