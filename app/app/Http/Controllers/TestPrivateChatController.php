<?php

namespace App\Http\Controllers;

use App\Events\TestPrivateChat;
use Illuminate\Http\Request;

class TestPrivateChatController extends Controller
{
    /**
     * メッセージ送信API（全体 or 個人宛）
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'from' => 'required|string',
            'to' => 'nullable|string',
            'message' => 'required|string',
        ]);

        $from = $request->input('from');
        $to = $request->input('to');
        $message = $request->input('message');

        // イベント発火（全体でも個人でも共通チャンネル）
        event(new TestPrivateChat($from, $to, $message));

        return response()->json(['status' => 'sent']);
    }
}
