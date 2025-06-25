<?php

namespace App\Http\Controllers\RealtimeRoutine;

use App\Http\Controllers\Controller;
use App\Http\Requests\RealtimeRoutine\RaiseHandRequest;
use App\Http\Resources\BaseApiResponse;
use App\Services\RealtimeRoutine\RaiseHandService;
use Illuminate\Http\JsonResponse;

class RaiseHandController extends Controller
{
    protected RaiseHandService $raiseHandService;

    public function __construct(
        RaiseHandService $raiseHandService
    ) {
        $this->raiseHandService = $raiseHandService;
    }

    /**
     * 参加者の挙手を受け取り、主催者に通知する
     */
    public function raiseHand(RaiseHandRequest $request): JsonResponse
    {
        // ソケット通知などの処理（サービス層へ委譲）
        $this->raiseHandService->notifyOwnerOfRaiseHand($request->validated());

        return response()->json(new BaseApiResponse([
            'code' => 200,
            'message' => 'OK',
            'data' => null,
        ]));
    }
}
