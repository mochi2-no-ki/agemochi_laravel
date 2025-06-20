<?php

namespace App\Repositories;

use App\Models\MessageType;

class MessageTypeRepository extends BaseRepository
{
    /**
     * コンストラクタ：MessageTypeモデルを注入
     */
    public function __construct(MessageType $messageType)
    {
        parent::__construct($messageType);
    }

    // 必要であればMessageType特有の処理をここに追加
}
