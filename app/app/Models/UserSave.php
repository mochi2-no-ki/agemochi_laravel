<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSave extends Model
{
    // テーブル名を明示
    protected $table = 'user_save';

    // 主キー
    protected $primaryKey = 'user_id';

    // UUID型（自動採番なし）
    public $incrementing = false;

    protected $keyType = 'string';

    // 複数代入可能なカラム
    protected $fillable = [
        'user_id',
        'routine_save_max',
        'realtime_routine_save_max',
        'created_at',
        'updated_at',
    ];

    /**
     * ユーザーアカウントとのリレーション
     */
    public function userAccount(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'user_id', 'user_id');
    }
}
