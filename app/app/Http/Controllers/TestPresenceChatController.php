<?php

namespace App\Http\Controllers;

use App\Events\TestPresenceChatMessage;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class TestPresenceChatController extends Controller
{
    /**
     * チャットメッセージ送信処理
     */
    public function send(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'sender' => ['required', 'string'], // ← 明示的に送る必要あり
            'receiver' => ['nullable', 'string'], // 空なら全体送信
            'message' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 共通データ作成（イベントとRedisで使用）
        $data = [
            'sender' => $request->input('sender'),
            'receiver' => $request->input('receiver') ?? '',
            'message_type' => empty($request->input('receiver')) ? 'announce' : 'reply',
            'message' => $request->input('message'),
            'timestamp' => now()->toIso8601String(),
        ];

        // 宛先の存在確認（reply時のみ）
        if ($data['message_type'] === 'reply') {
            $exists = UserAccount::where('mochi_id', $data['receiver'])->exists();
            if (! $exists) {
                return response()->json(['error' => 'Receiver not found'], 422);
            }
        }

        // イベント発火
        event(new TestPresenceChatMessage(
            $data['sender'],
            $data['receiver'],
            $data['message_type'],
            $data['message'],
            $data['timestamp'],
        ));

        // Redisに履歴保存（最大100件）
        Redis::rpush('chat:test_presence_chat', json_encode($data));
        Redis::ltrim('chat:test_presence_chat', -100, -1);

        return response()->json(['status' => 'ok']);
    }
}
