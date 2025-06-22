<?php

namespace App\Http\Controllers\Routine;

use App\Http\Controllers\Controller;
use App\Http\Requests\Routine\ListRoutineRequest;
use App\Http\Resources\BaseApiResponse;
use App\Http\Resources\Routine\RoutineListResource;
use App\Services\RoutineService;
use Illuminate\Http\JsonResponse;

class RoutineController extends Controller
{
    protected RoutineService $routineService;

    public function __construct(RoutineService $routineService)
    {
        $this->routineService = $routineService;
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
}
