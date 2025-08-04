<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class TestPresenceEventLogController extends Controller
{
    /**
     * Redis に保存されたイベント付きチャット履歴を取得
     */
    public function getLog(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'mochi_id' => ['required', 'string'],
            'realtime_routine_id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 422);
        }

        $myMochiId = $request->input('mochi_id');
        $realtimeRoutineId = $request->input('realtime_routine_id');

        $redisKey = "realtime_routine.messages.{$realtimeRoutineId}";
        $raw = Redis::lrange($redisKey, -100, -1);

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
