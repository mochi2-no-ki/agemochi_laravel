<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TestPresenceChatMessage implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public string $sender;

    public string $receiver;

    public string $messageType;

    public string $message;

    public string $createdAt;

    /**
     * Create a new event instance.
     */
    public function __construct(string $sender, string $receiver, string $messageType, string $message, string $createdAt)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->messageType = $messageType;
        $this->message = $message;
        $this->createdAt = $createdAt;
    }

    /**
     * チャンネル指定：全体送信は presence チャンネル、それ以外は個別
     */
    public function broadcastOn(): Channel|array
    {
        if ($this->messageType === 'announce') {
            return new PresenceChannel('test_presence_chat');
        }

        // receiverとsender両方に送信（PrivateChannel）
        return [
            new PrivateChannel("test_presence_chat.{$this->receiver}"),
            new PrivateChannel("test_presence_chat.{$this->sender}"),
        ];
    }

    /**
     * イベント名
     */
    public function broadcastAs(): string
    {
        return 'TestPresenceChatMessage';
    }

    /**
     * データペイロード
     */
    public function broadcastWith(): array
    {
        return [
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'message_type' => $this->messageType,
            'message' => $this->message,
            'created_at' => $this->createdAt,
        ];
    }
}
