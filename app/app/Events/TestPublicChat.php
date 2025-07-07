<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestPublicChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $user_id;

    public string $message;

    /**
     * コンストラクタ：イベント発火時に呼ばれる
     */
    public function __construct(string $user_id, string $message)
    {
        $this->user_id = $user_id;
        $this->message = $message;

        // 発火時ログ
        Log::info('[TestPublicChat] Event constructed', [
            'user_id' => $user_id,
            'message' => $message,
        ]);
    }

    /**
     * ブロードキャスト対象のチャンネルを定義
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('test_public_chat'),
        ];
    }

    /**
     * ブロードキャストされるイベント名
     */
    public function broadcastAs(): string
    {
        return 'PublicMessageSent';
    }

    /**
     * クライアントに送信するデータ構成
     */
    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->user_id,
            'message' => $this->message,
        ];
    }
}
