<?php

namespace App\Jobs;

use App\Repositories\RealtimeRoutineRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * リアルタイムルーティーンを「開催（HOLDING）」状態に更新するジョブ
 */
class HoldRealtimeRoutineJob implements ShouldQueue
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
        $repository = app(RealtimeRoutineRepository::class);
        $repository->markAsHolding($this->realtimeRoutineId);
    }
}
