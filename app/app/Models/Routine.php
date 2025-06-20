<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Routine extends Model
{
    use SoftDeletes; // deleted_at を使うため

    protected $table = 'routine';

    protected $primaryKey = 'routine_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'routine_id',
        'user_id',
        'routine_title',
        'routine_start',
        'routine_end',
        'routine_time',
        'routine_body',
        'realtime_routine_flag',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * ユーザーアカウントとのリレーション
     */
    public function userAccount(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'user_id', 'user_id');
    }
}
