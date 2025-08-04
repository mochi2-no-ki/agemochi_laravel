<?php

namespace App\Jobs;

use App\Events\Notification\RealtimeRoutineEnded;
use App\Repositories\RealtimeRoutineRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * リアルタイムルーティーンを「終了（ENDED）」状態に更新するジョブ
 */
class EndRealtimeRoutineJob implements ShouldQueue
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
        // リポジトリ経由で状態をENDEDに更新
        $repository = app(RealtimeRoutineRepository::class);
        $repository->markAsEnded($this->realtimeRoutineId);

        // 対象のpresenceチャンネルに対して通知をブロードキャスト
        event(new RealtimeRoutineEnded($this->realtimeRoutineId));
    }
}
