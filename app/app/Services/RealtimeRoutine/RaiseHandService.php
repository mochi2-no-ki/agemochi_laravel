<?php

namespace App\Services\RealtimeRoutine;

use App\Repositories\RealtimeRoutineRepository;

class RaiseHandService
{
    protected RealtimeRoutineRepository $realtimeRoutineRepository;

    public function __construct(RealtimeRoutineRepository $realtimeRoutineRepository)
    {
        $this->realtimeRoutineRepository = $realtimeRoutineRepository;
    }

    /**
     * 主催者に挙手通知を送信する処理
     */
    public function notifyOwnerOfRaiseHand(array $params): void
    {
        // ルーティーンの存在確認（Repository経由）
        $realtimeRoutine = $this->realtimeRoutineRepository->find($params['realtime_routine_id']);

        // TODO: ソケット通知などの実装をここに記述

        // 例: イベントを発火させるなど（未実装）
        // event(new RaiseHandEvent($realtimeRoutine->owner_user_id, $mochiId));
    }
}
