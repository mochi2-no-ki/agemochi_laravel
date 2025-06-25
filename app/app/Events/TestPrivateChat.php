<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestPrivateChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $from;

    public ?string $to;

    public string $message;

    /**
     * Create a new event instance.
     */
    public function __construct(string $from, ?string $to, string $message)
    {
        $this->from = $from;
        $this->to = $to;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        // 宛先が指定されていない場合は全体チャンネルに送信
        if (empty($this->to)) {
            return [new Channel('test_private_chat')];
        }

        // 個別送信の場合は送信者・受信者のチャンネルにのみ送信
        return [
            new Channel("test_private_chat.{$this->from}"),
            new Channel("test_private_chat.{$this->to}"),
        ];

        // 将来 PrivateChannel を使う場合（認証が必要）
        // return [
        //     new PrivateChannel("test_private_chat.{$this->from}"),
        //     new PrivateChannel("test_private_chat.{$this->to}"),
        // ];
    }

    /**
     * イベント名をカスタム（JS側と一致）
     */
    public function broadcastAs(): string
    {
        return 'TestPrivateChat';
    }

    /**
     * 送信データ
     */
    public function broadcastWith(): array
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'message' => $this->message,
        ];
    }
}
