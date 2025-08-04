<?php

namespace App\Services\RealtimeRoutine;

use App\Models\RealtimeRoutine;
use App\Repositories\RealtimeRoutineRepository;
use App\Repositories\RoutineRepository;
use App\Services\Support\UuidService;

class CreateRealtimeRoutineService
{
    protected RoutineRepository $routineRepository;

    protected RealtimeRoutineRepository $realtimeRoutineRepository;

    public function __construct(
        RoutineRepository $routineRepository,
        RealtimeRoutineRepository $realtimeRoutineRepository
    ) {
        $this->routineRepository = $routineRepository;
        $this->realtimeRoutineRepository = $realtimeRoutineRepository;
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
    public function createRealtimeRoutine(array $input): RealtimeRoutine
    {
        $routineId = $input['routine_id'];
        $userId = $input['user_id'];
        $startTime = $input['start_time'];
        $endTime = $input['end_time'];

        // 対象ルーティーンが存在するか確認
        $routine = $this->routineRepository->find($routineId);
        if (! $routine) {
            abort(404, '指定されたルーティーンが存在しません。');
        }

        return $this->realtimeRoutineRepository->create([
            'realtime_routine_id' => UuidService::generateV7(),
            'routine_id' => $routineId,
            'owner_user_id' => $userId,
            'realtime_routine_title' => $routine->routine_title,
            'start_time' => $startTime.':00',
            'end_time' => $endTime.':00',
            'actual_end_time' => null,
            'realtime_status_id' => config('constants.REALTIME_STATUS.SCHEDULED'), // スケジュール済み状態で作成
        ]);
    }
}
