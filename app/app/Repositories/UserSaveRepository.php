<?php

namespace App\Repositories;

use App\Models\UserSave;

class UserSaveRepository extends BaseRepository
{
    /**
     * コンストラクタ：UserSaveモデルを注入
     */
    public function __construct(UserSave $userSave)
    {
        parent::__construct($userSave);
    }

    // 必要であればUserSave特有の処理をここに追加
}
