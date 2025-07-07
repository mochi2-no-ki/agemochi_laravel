<?php

namespace App\Http\Controllers;

use App\Events\TestPublicChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestPublicChatController extends Controller
{
    /**
     * 公開チャットメッセージを受け取り、イベントをブロードキャストする
     */
    public function send(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        $userId = $request->input('user_id');
        $message = $request->input('message');

        Log::info('[TestPublicChatController] メッセージ送信', [
            'user_id' => $userId,
            'message' => $message,
        ]);

        // broadcast(new TestPublicChat($userId, $message));
        event(new TestPublicChat($userId, $message));

        return response()->json(['status' => 'sent']);
    }
}
