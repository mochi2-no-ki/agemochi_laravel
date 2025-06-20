<?php

namespace App\Repositories;

use App\Models\RealtimeStatus;

class RealtimeStatusRepository extends BaseRepository
{
    /**
     * コンストラクタ：RealtimeStatusモデルを注入
     */
    public function __construct(RealtimeStatus $realtimeStatus)
    {
        parent::__construct($realtimeStatus);
    }

    // 必要であればRealtimeStatus特有の処理をここに追加
}
