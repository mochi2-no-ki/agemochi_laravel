<?php

namespace App\Repositories;

use App\Models\RoutineView;

class RoutineViewRepository extends BaseRepository
{
    /**
     * コンストラクタ：RoutineViewモデルを注入
     */
    public function __construct(RoutineView $routineView)
    {
        parent::__construct($routineView);
    }

    // 必要であればRoutineView特有の処理をここに追加
}
