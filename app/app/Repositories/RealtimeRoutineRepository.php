<?php

namespace App\Repositories;

use App\Models\RealtimeRoutine;

class RealtimeRoutineRepository extends BaseRepository
{
    /**
     * コンストラクタ：RealtimeRoutineモデルを注入
     */
    public function __construct(RealtimeRoutine $realtimeRoutine)
    {
        parent::__construct($realtimeRoutine);
    }

    // 必要であればRealtimeRoutine特有の処理をここに追加
}
