<?php

namespace App\Services\Routine;

use App\Repositories\RoutineRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowRoutineDetailService
{
    protected RoutineRepository $routineRepository;

    public function __construct(RoutineRepository $routineRepository)
    {
        $this->routineRepository = $routineRepository;
    }

    /**
     * ルーティーン詳細を取得する
     *
     * @return \App\Models\Routine
     *
     * @throws ModelNotFoundException
     */
    public function getDetailById(string $routineId)
    {
        return $this->routineRepository->baseQuery()
            ->with([
                'routineTags.tag',
                'userAccount',
                'realtimeRoutines',
            ])
            ->withCount('routineSaves') // 保存数をカウント
            ->join('routine_view', 'routine.routine_id', '=', 'routine_view.routine_id')
            ->addSelect('routine.*', 'routine_view.reference_count') // 閲覧数も取得
            ->where('routine.routine_id', $routineId)
            ->firstOrFail();
    }
}
