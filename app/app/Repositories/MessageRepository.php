<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository extends BaseRepository
{
    /**
     * コンストラクタ：Messageモデルを注入
     */
    public function __construct(Message $message)
    {
        parent::__construct($message);
    }

    // 必要であればMessage特有の処理をここに追加
}
