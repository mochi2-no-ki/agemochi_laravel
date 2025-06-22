<?php

namespace App\Http\Controllers\Routine;

use App\Http\Controllers\Controller;
use App\Http\Requests\Routine\ListRoutineRequest;
use App\Http\Resources\BaseApiResponse;
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
        $data = $routines->map(function ($routine) {
            return [
                'routine_id' => $routine->routine_id,
                'routine_title' => $routine->routine_title,
                'routine_time' => $routine->routine_time,
                'tags' => optional($routine->routineTags)->map(function ($routineTag) {
                    return ['tag_name' => optional($routineTag->tag)->tag_name];
                }) ?? [],
                'user' => [
                    'mochi_id' => optional($routine->userAccount)->mochi_id,
                    'user_name' => optional($routine->userAccount)->user_name,
                    'user_img_path' => optional($routine->userAccount)->user_img_path,
                ],
                'reference_count' => $routine->reference_count,
                'routine_save_count' => $routine->routine_saves_count,
            ];
        });

        return response()->json(new BaseApiResponse([
            'code' => 200,
            'message' => 'OK',
            'data' => $data,
        ]));
    }
}
