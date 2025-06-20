<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RealtimeRoutineSave extends Model
{
    protected $table = 'realtime_routine_save';

    protected $primaryKey = 'realtime_routine_save_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'realtime_routine_save_id',
        'user_id',
        'routine_id',
        'created_at',
    ];

    /**
     * ユーザーとのリレーション
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserSave::class, 'user_id', 'user_id');
    }

    /**
     * ルーティーンとのリレーション
     */
    public function routine(): BelongsTo
    {
        return $this->belongsTo(Routine::class, 'routine_id', 'routine_id');
    }
}
