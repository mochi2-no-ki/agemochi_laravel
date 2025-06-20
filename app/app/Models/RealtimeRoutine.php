<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RealtimeRoutine extends Model
{
    protected $table = 'realtime_routine';

    protected $primaryKey = 'realtime_routine_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'realtime_routine_id',
        'routine_id',
        'owner_user_id',
        'realtime_routine_title',
        'start_time',
        'end_time',
        'actual_end_time',
        'realtime_status_id',
        'created_at',
        'updated_at',
    ];

    /**
     * ルーティーンとのリレーション
     */
    public function routine(): BelongsTo
    {
        return $this->belongsTo(Routine::class, 'routine_id', 'routine_id');
    }

    /**
     * 開催者ユーザーとのリレーション
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'owner_user_id', 'user_id');
    }

    /**
     * ステータスとのリレーション
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(RealtimeStatus::class, 'realtime_status_id', 'realtime_status_id');
    }
}
