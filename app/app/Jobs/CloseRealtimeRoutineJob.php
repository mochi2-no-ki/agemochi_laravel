<?php

namespace App\Jobs;

use App\Events\Notification\RealtimeRoutineClosed;
use App\Repositories\MessageRepository;
use App\Repositories\RealtimeRoutineRepository;
use App\Services\Support\UuidService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

/**
 * リアルタイムルーティーンを終了・閉会するジョブ
 */
class CloseRealtimeRoutineJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $realtimeRoutineId;

    /**
     * コンストラクタ
     */
    public function __construct(string $realtimeRoutineId)
    {
        $this->realtimeRoutineId = $realtimeRoutineId;
    }

    /**
     * ジョブの実行処理
     */
    public function handle(): void
    {
        // ステータスを ENDED に更新
        $realtimeRepo = app(RealtimeRoutineRepository::class);
        $realtimeRepo->markAsEnded($this->realtimeRoutineId);

        // Redis からメッセージ一覧取得
        $redisMessageKey = "realtime_routine.messages.{$this->realtimeRoutineId}";
        $rawMessages = Redis::lrange($redisMessageKey, 0, -1);

        // メッセージを DB に保存
        $messageRepo = app(MessageRepository::class);

        foreach ($rawMessages as $rawMessage) {
            $data = json_decode($rawMessage, true);

            // $messageRepo->create([
            //     'message_id' => UuidService::generateV7(),
            //     'realtime_routine_id' => $this->realtimeRoutineId,
            //     'user_id' => $data['user_id'],
            //     'message_type_id' => $data['message_type_id'],
            //     'message_body' => $data['message_body'],
            //     'reply_user_id' => $data['reply_user_id'],
            //     'created_at' => $data['created_at'],
            // ]);
        }

        // Redisのキーを削除
        Redis::del($redisMessageKey);

        // 閉会イベントをブロードキャスト
        event(new RealtimeRoutineClosed($this->realtimeRoutineId));
    }
}
