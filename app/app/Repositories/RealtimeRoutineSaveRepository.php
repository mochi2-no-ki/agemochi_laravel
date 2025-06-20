<?php

namespace App\Repositories;

use App\Models\RealtimeRoutineSave;

class RealtimeRoutineSaveRepository extends BaseRepository
{
    /**
     * コンストラクタ：RealtimeRoutineSaveモデルを注入
     */
    public function __construct(RealtimeRoutineSave $realtimeRoutineSave)
    {
        parent::__construct($realtimeRoutineSave);
    }

    // 必要であればRealtimeRoutineSave特有の処理をここに追加
}
