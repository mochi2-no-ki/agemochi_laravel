<?php

namespace App\Repositories;

use App\Models\RealtimeRoutine;

class RealtimeRoutineRepository extends BaseRepository
{
    /**
     * コンストラクタ：RealtimeRoutineモデルを注入
     */
    public function __construct(RealtimeRoutine $realtimeRoutine)
    {
        parent::__construct($realtimeRoutine);
    }

    // 必要であればRealtimeRoutine特有の処理をここに追加
    /**
     * 指定されたルーティーンIDに対応する開催中（holding）状態のリアルタイムルーティーンを取得
     */
    public function findHoldingByRoutineId(string $routineId): ?RealtimeRoutine
    {
        return $this->baseQuery()
            ->where('routine_id', $routineId)
            ->where('realtime_status_id', config('constants.REALTIME_STATUS.HOLDING')) // holding
            ->first();
    }

    /**
     * 指定されたルーティーンIDに対応するスケジュール済み（scheduled）状態のリアルタイムルーティーンを取得
     */
    public function findScheduledByRoutineId(string $routineId): ?RealtimeRoutine
    {
        return $this->baseQuery()
            ->where('routine_id', $routineId)
            ->where('realtime_status_id', config('constants.REALTIME_STATUS.SCHEDULED')) // scheduled
            ->first();
    }

    /**
     * 任意のステータスIDに更新する汎用メソッド（内部使用）
     */
    protected function updateStatus(string $id, string $statusId): ?RealtimeRoutine
    {
        $routine = $this->find($id);
        if (! $routine) {
            return null;
        }

        $routine->realtime_status_id = $statusId;
        $routine->save();

        return $routine;
    }

    /**
     * 指定されたリアルタイムルーティーンIDを「開催中（HOLDING）」状態に更新
     */
    public function markAsHolding(string $id): ?RealtimeRoutine
    {
        return $this->updateStatus($id, config('constants.REALTIME_STATUS.HOLDING'));
    }

    /**
     * 指定されたリアルタイムルーティーンIDを「終了済み（ENDED）」状態に更新
     */
    public function markAsEnded(string $id): ?RealtimeRoutine
    {
        return $this->updateStatus($id, config('constants.REALTIME_STATUS.ENDED'));
    }
}
