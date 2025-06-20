<?php

namespace App\Repositories;

use App\Models\UserLogin;

class UserLoginRepository extends BaseRepository
{
    /**
     * コンストラクタ：UserLoginモデルを注入
     */
    public function __construct(UserLogin $userLogin)
    {
        parent::__construct($userLogin);
    }

    // 必要であればUserLogin特有の処理をここに追加
}
