<?php

namespace App\Repositories;

use App\Models\RoutineSave;

class RoutineSaveRepository extends BaseRepository
{
    /**
     * コンストラクタ：RoutineSaveモデルを注入
     */
    public function __construct(RoutineSave $routineSave)
    {
        parent::__construct($routineSave);
    }

    // 必要であればRoutineSave特有の処理をここに追加
}
