<?php

namespace App\Services\RealtimeRoutine;

use App\Models\RealtimeRoutine;
use App\Repositories\RealtimeRoutineRepository;
use App\Repositories\RoutineRepository;

class GetRealtimeRoutineService
{
    protected RoutineRepository $routineRepository;

    protected RealtimeRoutineRepository $realtimeRoutineRepository;

    /**
     * コンストラクタ
     */
    public function __construct(
        RoutineRepository $routineRepository,
        RealtimeRoutineRepository $realtimeRoutineRepository
    ) {
        $this->routineRepository = $routineRepository;
        $this->realtimeRoutineRepository = $realtimeRoutineRepository;
    }

    /**
     * holding中のリアルタイムルーティーンを取得する
     * なければ null を返す。
     */
    public function getHoldingRealtimeRoutine(string $routineId): ?RealtimeRoutine
    {
        // 対象ルーティーンが存在するか確認
        $routine = $this->routineRepository->find($routineId);
        if (! $routine) {
            abort(404, '指定されたルーティーンが存在しません。');
        }

        return $this->realtimeRoutineRepository->findHoldingByRoutineId($routineId);
    }

    /**
     * scheduled状態のリアルタイムルーティーンを取得する
     * なければ null を返す。
     */
    public function getScheduledRealtimeRoutine(string $routineId): ?RealtimeRoutine
    {
        // 対象ルーティーンが存在するか確認
        $routine = $this->routineRepository->find($routineId);
        if (! $routine) {
            abort(404, '指定されたルーティーンが存在しません。');
        }

        return $this->realtimeRoutineRepository->findScheduledByRoutineId($routineId);
    }
}
