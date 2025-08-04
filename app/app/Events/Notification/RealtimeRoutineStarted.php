<?php

namespace App\Events\Notification;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeRoutineStarted implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public string $realtimeRoutineId;

    /**
     * コンストラクタ
     */
    public function __construct(string $realtimeRoutineId)
    {
        $this->realtimeRoutineId = $realtimeRoutineId;
    }

    /**
     * ブロードキャストチャンネル（presence）
     */
    public function broadcastOn(): Channel
    {
        return new PresenceChannel("presence_realtime_routine.{$this->realtimeRoutineId}");
    }

    /**
     * イベント名（クライアント側で識別）
     */
    public function broadcastAs(): string
    {
        return 'realtime_routine.started';
    }
}
