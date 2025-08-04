<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TestPresenceEventMessage implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public string $realtimeRoutineId;

    public string $sender;

    public string $receiver;

    public string $messageType;

    public string $message;

    public string $createdAt;

    /**
     * Create a new event instance.
     */
    public function __construct(
        string $realtimeRoutineId,
        string $sender,
        string $receiver,
        string $messageType,
        string $message,
        string $createdAt
    ) {
        $this->realtimeRoutineId = $realtimeRoutineId;
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
            return new PresenceChannel("presence_realtime_routine.{$this->realtimeRoutineId}");
        }

        // receiverとsender両方に送信（PrivateChannel）
        return [
            new PrivateChannel("private_realtime_routine.{$this->realtimeRoutineId}.{$this->receiver}"),
            new PrivateChannel("private_realtime_routine.{$this->realtimeRoutineId}.{$this->sender}"),
        ];
    }

    /**
     * イベント名
     */
    public function broadcastAs(): string
    {
        return 'realtime_routine.message';
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
