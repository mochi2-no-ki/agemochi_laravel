<?php

namespace App\Http\Controllers\Routine;

use App\Http\Controllers\Controller;
use App\Http\Requests\Routine\CreateRoutineRequest;
use App\Http\Requests\Routine\HoldEventRequest;
use App\Http\Requests\Routine\ListRoutineRequest;
use App\Http\Resources\BaseApiResponse;
use App\Http\Resources\Routine\RoutineListResource;
use App\Http\Resources\Routine\ShowRoutineDetailResource;
use App\Services\RealtimeRoutine\HoldEventService;
use App\Services\Routine\CreateRoutineService;
use App\Services\Routine\RoutineListService;
use App\Services\Routine\ShowRoutineDetailService;
use Illuminate\Http\JsonResponse;

class RoutineController extends Controller
{
    protected RoutineListService $routineService;

    protected ShowRoutineDetailService $showRoutineDetailService;

    protected CreateRoutineService $createRoutineService;

    protected HoldEventService $holdEventService;

    public function __construct(
        RoutineListService $routineService,
        ShowRoutineDetailService $showRoutineDetailService,
        CreateRoutineService $createRoutineService,
        HoldEventService $holdEventService,
    ) {
        $this->routineService = $routineService;
        $this->showRoutineDetailService = $showRoutineDetailService;
        $this->createRoutineService = $createRoutineService;
        $this->holdEventService = $holdEventService;
    }

    /**
     * ルーティーン一覧取得API
     */
    public function list(ListRoutineRequest $request): JsonResponse
    {
        $routines = $this->routineService->getListByConditions($request->validated());

        // 各ルーティーンを整形
        $data = RoutineListResource::collection($routines);

        return response()->json(new BaseApiResponse([
            'code' => 200,
            'message' => 'OK',
            'data' => $data,
        ]));
    }

    /**
     * ルーティーン詳細取得API
     */
    public function showDetail(string $routineId): JsonResponse
    {
        $routine = $this->showRoutineDetailService->getDetailById($routineId);

        if (! $routine) {
            return response()->json(new BaseApiResponse([
                'code' => 404,
                'message' => '指定されたルーティーンが見つかりません。',
                'data' => null,
            ]), 404);
        }

        $data = new ShowRoutineDetailResource($routine);

        return response()->json(new BaseApiResponse([
            'code' => 200,
            'message' => 'OK',
            'data' => $data,
        ]));
    }

    /**
     * ルーティーン投稿API
     */
    public function create(CreateRoutineRequest $request): JsonResponse
    {
        $routine = $this->createRoutineService->createRoutine($request->validated());

        return response()->json(new BaseApiResponse([
            'code' => 200,
            'message' => 'OK',
            'data' => [
                'routine_id' => $routine->routine_id,
            ],
        ]));
    }

    /**
     * リアルタイムルーティーン開催API
     */
    public function holdEvent(HoldEventRequest $request): JsonResponse
    {
        $input = $request->validated();

        $realtimeRoutine = $this->holdEventService->holdEvent($input);

        return response()->json(new BaseApiResponse([
            'code' => 200,
            'message' => 'OK',
            'data' => [
                'realtime_routine_id' => $realtimeRoutine->realtime_routine_id,
            ],
        ]));
    }
}
