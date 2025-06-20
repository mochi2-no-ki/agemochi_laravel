<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RealtimeRoutineParticipant extends Model
{
    protected $table = 'realtime_routine_participant';

    protected $primaryKey = 'realtime_routine_participant_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'realtime_routine_participant_id',
        'realtime_routine_id',
        'user_id',
        'created_at',
    ];

    /**
     * リアルタイムルーティーンとのリレーション
     */
    public function realtimeRoutine(): BelongsTo
    {
        return $this->belongsTo(RealtimeRoutine::class, 'realtime_routine_id', 'realtime_routine_id');
    }

    /**
     * 参加ユーザーとのリレーション
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'user_id', 'user_id');
    }
}
