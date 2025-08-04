<?php

namespace App\Http\Controllers;

use App\Events\TestPresenceEventMessage;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class TestPresenceEventController extends Controller
{
    /**
     * チャットメッセージ送信処理
     */
    public function send(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'sender' => ['required', 'string'], // 明示的に送る必要あり
            'receiver' => ['nullable', 'string'], // 空なら全体送信
            'message' => ['required', 'string'],
            'realtime_routine_id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $realtimeRoutineId = $request->input('realtime_routine_id');

        // 共通データ作成（イベントとRedisで使用）
        $data = [
            'sender' => $request->input('sender'),
            'receiver' => $request->input('receiver') ?? '',
            'message_type' => empty($request->input('receiver')) ? 'announce' : 'reply',
            'message' => $request->input('message'),
            'timestamp' => now()->toIso8601String(),
        ];

        // 今後使用予定の正式フォーマット
        /*
        $data = [
            'user_id' => 'ユーザーのUUID',
            'user_mochi_id' => 'UIで使う表示用ID',
            'message_type_id' => '003', // ANNOUNCE, QUESTIONなど
            'message_body' => '今日もがんばりましょう！',
            'reply_user_id' => null, // UUID（DB保存用）
            'reply_mochi_user_id' => null, // 表示用
            'created_at' => '2025-07-22T10:00:00'
        ];
        */

        // 宛先の存在確認（reply時のみ）
        if ($data['message_type'] === 'reply') {
            $exists = UserAccount::where('mochi_id', $data['receiver'])->exists();
            if (! $exists) {
                return response()->json(['error' => 'Receiver not found'], 422);
            }
        }

        // イベント発火
        event(new TestPresenceEventMessage(
            $realtimeRoutineId,
            $data['sender'],
            $data['receiver'],
            $data['message_type'],
            $data['message'],
            $data['timestamp'],
        ));

        // Redisに履歴保存（最大100件）
        $redisKey = "realtime_routine.messages.{$realtimeRoutineId}";
        Redis::rpush($redisKey, json_encode($data));
        Redis::ltrim($redisKey, -100, -1);

        return response()->json(['status' => 'ok']);
    }
}
