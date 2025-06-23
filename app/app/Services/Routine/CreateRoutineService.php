<?php

namespace App\Services\Routine;

use App\Models\Routine;
use App\Models\RoutineView;
use App\Repositories\RoutineRepository;
use App\Repositories\RoutineViewRepository;
use App\Services\Support\UuidService;
use Illuminate\Support\Facades\DB;

class CreateRoutineService
{
    protected RoutineRepository $routineRepository;

    protected RoutineViewRepository $routineViewRepository;

    protected RoutineTagSyncService $routineTagSyncService;

    public function __construct(
        RoutineRepository $routineRepository,
        RoutineViewRepository $routineViewRepository,
        RoutineTagSyncService $routineTagSyncService
    ) {
        $this->routineRepository = $routineRepository;
        $this->routineViewRepository = $routineViewRepository;
        $this->routineTagSyncService = $routineTagSyncService;
    }

    /**
     * ルーティーン投稿処理
     */
    public function createRoutine(array $data): Routine
    {
        return DB::transaction(function () use ($data) {
            $routineId = UuidService::generateV7();

            // Routine 登録
            $routine = $this->routineRepository->create([
                'routine_id' => $routineId,
                'user_id' => $data['user_id'],
                'routine_title' => $data['routine_title'],
                'routine_start' => $data['routine_start'],
                'routine_end' => $data['routine_end'],
                'routine_time' => $data['routine_time'],
                'routine_body' => $data['routine_body'] ?? null,
                'realtime_routine_flag' => $data['realtime_routine_flag'],
                'created_at' => now(),
            ]);

            // RoutineView 初期化（view_count = 0）
            $this->routineViewRepository->create([
                'routine_id' => $routineId,
                'reference_count' => 0,
                'view_count' => 0,
                'created_at' => now(),
            ]);

            // タグの登録（存在すれば）
            if (! empty($data['tags'])) {
                $this->routineTagSyncService->syncTags($routineId, $data['tags']);
            }

            return $routine;
        });
    }
}
