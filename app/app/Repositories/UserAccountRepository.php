<?php

namespace App\Repositories;

use App\Models\UserAccount;

class UserAccountRepository extends BaseRepository
{
    /**
     * コンストラクタ：UserAccountモデルを注入
     */
    public function __construct(UserAccount $userAccount)
    {
        parent::__construct($userAccount);
    }

    // 必要であればここにUserAccount専用の処理を追加
}
