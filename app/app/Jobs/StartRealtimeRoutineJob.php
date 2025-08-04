<?php

namespace App\Jobs;

use App\Events\Notification\RealtimeRoutineStarted;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * リアルタイムルーティーンの「開始通知」を行うジョブ
 */
class StartRealtimeRoutineJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $realtimeRoutineId;

    /**
     * コンストラクタ
     */
    public function __construct(string $realtimeRoutineId)
    {
        $this->realtimeRoutineId = $realtimeRoutineId;
    }

    /**
     * ジョブの実行処理
     */
    public function handle(): void
    {
        // ソケット通知イベントを発火（Presenceチャンネルに向けて）
        event(new RealtimeRoutineStarted($this->realtimeRoutineId));
    }
}
