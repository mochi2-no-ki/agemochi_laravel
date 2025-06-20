<?php

namespace App\Repositories;

use App\Models\Routine;

class RoutineRepository extends BaseRepository
{
    /**
     * コンストラクタ：Routineモデルを注入
     */
    public function __construct(Routine $routine)
    {
        parent::__construct($routine);
    }

    // 必要であればRoutine特有の処理をここに追加
}
