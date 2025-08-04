<?php

namespace App\Services\RealtimeRoutine;

use App\Models\RealtimeRoutine;

class HoldEventService
{
    protected GetRealtimeRoutineService $getRealtimeRoutineService;

    protected CreateRealtimeRoutineService $createService;

    protected EventSchedulerService $schedulerService;

    public function __construct(
        GetRealtimeRoutineService $getRealtimeRoutineService,
        CreateRealtimeRoutineService $createService,
        EventSchedulerService $schedulerService,
    ) {
        $this->getRealtimeRoutineService = $getRealtimeRoutineService;
        $this->createService = $createService;
        $this->schedulerService = $schedulerService;
    }

    /**
     * 新しいリアルタイムルーティーンを作成する
     *
     * @param  array  $input  [
     *                        'routine_id' => string,
     *                        'user_id' => string,
     *                        'start_time' => string, // 'Y-m-d H:i'
     *                        'end_time' => string
     *                        ]
     */
    public function holdEvent(array $input): RealtimeRoutine
    {
        // すでに holding 中のリアルタイムルーティーンがあるか確認
        $realtimeRoutine = $this->getRealtimeRoutineService->getHoldingRealtimeRoutine($input['routine_id']);

        // あればそのまま返却（開催処理は行わない）
        if ($realtimeRoutine) {
            return $realtimeRoutine;
        }

        // すでに scheduled 状態のリアルタイムルーティーンがあるか確認
        $realtimeRoutine = $this->getRealtimeRoutineService->getScheduledRealtimeRoutine($input['routine_id']);

        // あればそのまま返却（開催処理は行わない）
        if ($realtimeRoutine) {
            return $realtimeRoutine;
        }

        // なければ作成して開催
        $realtimeRoutine = $this->createService->createRealtimeRoutine($input);

        // 開催処理を実行
        $this->schedulerService->scheduleAllJobs($realtimeRoutine);

        return $realtimeRoutine;
    }
}
