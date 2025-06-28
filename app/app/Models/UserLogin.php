<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class UserLogin extends Authenticatable
{
    use HasApiTokens;

    // 対応テーブル名
    protected $table = 'user_login';

    // 主キー
    protected $primaryKey = 'user_id';

    // UUID型（自動採番なし）
    public $incrementing = false;

    protected $keyType = 'string';

    // 複数代入可能なカラム
    protected $fillable = [
        'user_id',
        'mail',
        'password',
        'created_at',
        'updated_at',
    ];

    // 自動変換
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * ユーザーアカウントへのリレーション
     */
    public function userAccount(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'user_id', 'user_id');
    }
}
