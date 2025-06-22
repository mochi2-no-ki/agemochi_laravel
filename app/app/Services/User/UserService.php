<?php

namespace App\Services\User;

use App\Repositories\UserAccountRepository;

class UserService
{
    protected UserAccountRepository $userAccountRepository;

    /**
     * コンストラクタ：UserAccountRepositoryを注入
     */
    public function __construct(UserAccountRepository $userAccountRepository)
    {
        $this->userAccountRepository = $userAccountRepository;
    }

    /**
     * mochi_id に基づいてユーザーの簡易プロフィール情報を取得する
     */
    public function getSimpleProfileByMochiId(string $mochiId): ?array
    {
        $user = $this->userAccountRepository
            ->baseQuery()
            ->where('mochi_id', $mochiId)
            ->first();

        if (! $user) {
            return null;
        }

        return [
            'mochi_id' => $user->mochi_id,
            'user_name' => $user->user_name,
            'user_img_path' => $user->user_img_path,
        ];
    }
}
