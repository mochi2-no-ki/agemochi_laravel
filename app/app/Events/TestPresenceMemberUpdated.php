<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TestPresenceMemberUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public array $members;

    /**
     * Create a new event instance.
     */
    public function __construct(array $members)
    {
        $this->members = $members;
    }

    /**
     * チャンネル指定
     */
    public function broadcastOn(): Channel
    {
        return new PresenceChannel('test_presence_chat');
    }

    /**
     * イベント名を指定（オプション）
     */
    public function broadcastAs(): string
    {
        return 'TestPresenceMemberUpdated';
    }
}
