<?php

namespace App\Events\Notification;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * リアルタイムルーティーンの「閉会」イベント
 * - クライアントに終了を通知するための Presence ブロードキャスト
 */
class RealtimeRoutineClosed implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    protected string $realtimeRoutineId;

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
        return 'realtime_routine.closed';
    }
}
