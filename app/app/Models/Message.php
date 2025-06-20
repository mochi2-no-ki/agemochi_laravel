<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $table = 'message';

    protected $primaryKey = 'message_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'message_id',
        'realtime_routine_id',
        'user_id',
        'message_type_id',
        'message_body',
        'reply_user_id',
        'created_at',
    ];

    /**
     * 開催中ルーティーンとのリレーション
     */
    public function realtimeRoutine(): BelongsTo
    {
        return $this->belongsTo(RealtimeRoutine::class, 'realtime_routine_id', 'realtime_routine_id');
    }

    /**
     * 送信者とのリレーション
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'user_id', 'user_id');
    }

    /**
     * メッセージタイプとのリレーション
     */
    public function messageType(): BelongsTo
    {
        return $this->belongsTo(MessageType::class, 'message_type_id', 'message_type_id');
    }

    /**
     * 返信相手のユーザーとのリレーション（オプション）
     */
    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'reply_user_id', 'user_id');
    }
}
