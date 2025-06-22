<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ShowSimpleProfileRequest;
use App\Http\Resources\BaseApiResponse;
use App\Services\User\UserService;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected UserService $userService;

    /**
     * コンストラクタ：UserService を注入
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 指定された mochi_id に基づきユーザーの簡易プロフィールを返す
     */
    public function showSimpleProfile(ShowSimpleProfileRequest $request, string $mochi_id)
    {
        $validatedMochiId = $request->route('mochi_id');

        $user = $this->userService->getSimpleProfileByMochiId($validatedMochiId);

        if (! $user) {
            return new BaseApiResponse([
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'User not found',
                'data' => null,
            ]);
        }

        return new BaseApiResponse([
            'code' => Response::HTTP_OK,
            'message' => 'OK',
            'data' => $user,
        ]);
    }
}
