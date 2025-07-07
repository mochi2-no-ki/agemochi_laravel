<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class TestPresenceChatLogController extends Controller
{
    /**
     * Redis に保存されたチャット履歴を取得
     */
    public function getLog(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'mochi_id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid mochi_id'], 422);
        }

        // リクエストから mochi_id を取得
        $myMochiId = $request->input('mochi_id');

        $raw = Redis::lrange('chat:test_presence_chat', -100, -1);

        $logs = collect($raw)
            ->map(fn ($item) => json_decode($item, true))
            ->filter(function ($log) use ($myMochiId) {
                return $log['message_type'] === 'announce' ||
                    ($log['message_type'] === 'reply' &&
                        ($log['receiver'] === $myMochiId || $log['sender'] === $myMochiId));
            })
            ->values();

        return response()->json($logs);
    }
}
