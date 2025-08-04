<?php

namespace App\Services\RealtimeRoutine;

use App\Repositories\RealtimeRoutineRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class ChannelAuthService
{
    protected RealtimeRoutineRepository $realtimeRoutineRepository;

    /**
     * コンストラクタ
     */
    public function __construct(RealtimeRoutineRepository $realtimeRoutineRepository)
    {
        $this->realtimeRoutineRepository = $realtimeRoutineRepository;
    }

    /**
     * リアルタイムルーティーンが購読可能な状態かどうかを判定する
     */
    public function isAccessible(string $realtimeRoutineId): bool
    {
        $realtimeRoutine = $this->realtimeRoutineRepository->baseQuery()
            ->where('realtime_routine_id', $realtimeRoutineId)
            ->first();

        if (! $realtimeRoutine) {
            return false;
        }

        $now = Carbon::now();
        $holdOffset = Config::get('constants.REALTIME_ROUTINE.HOLD_MINUTES_BEFORE');
        $closeOffset = Config::get('constants.REALTIME_ROUTINE.CLOSE_MINUTES_AFTER');
        $startWindow = Carbon::parse($realtimeRoutine->start_time)->subMinutes($holdOffset);
        $endWindow = Carbon::parse($realtimeRoutine->end_time)->addMinutes($closeOffset);

        return $now->between($startWindow, $endWindow);
    }
}
