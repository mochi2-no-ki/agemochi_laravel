<?php

namespace App\Repositories;

use App\Models\RealtimeRoutineParticipant;

class RealtimeRoutineParticipantRepository extends BaseRepository
{
    /**
     * コンストラクタ：RealtimeRoutineParticipantモデルを注入
     */
    public function __construct(RealtimeRoutineParticipant $participant)
    {
        parent::__construct($participant);
    }

    // 必要であればRealtimeRoutineParticipant特有の処理をここに追加
}
