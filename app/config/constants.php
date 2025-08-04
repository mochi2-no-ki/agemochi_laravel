<?php

return [

    // RealtimeRoutine のステータス定義
    'REALTIME_STATUS' => [
        'SCHEDULED' => '001', // 予定
        'HOLDING' => '002', // 開催中
        'ENDED' => '003', // 終了
    ],

    // MessageType の定義
    'MESSAGE_TYPE' => [
        'NORMAL' => '001',
        'GREETING' => '002',
        'ANNOUNCE' => '003',
        'QUESTION' => '004',
        'REPLY' => '005',
    ],

    // RealtimeRoutine の設定
    'REALTIME_ROUTINE' => [
        'HOLD_MINUTES_BEFORE' => 5,
        'CLOSE_MINUTES_AFTER' => 2,
    ],
];
