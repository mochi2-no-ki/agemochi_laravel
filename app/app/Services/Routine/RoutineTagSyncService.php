<?php

namespace App\Services\Routine;

use App\Repositories\RoutineTagRepository;
use App\Services\Support\UuidService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoutineTagSyncService
{
    protected RoutineTagRepository $routineTagRepository;

    public function __construct(RoutineTagRepository $routineTagRepository)
    {
        $this->routineTagRepository = $routineTagRepository;
    }

    /**
     * タグ配列をもとに routine_tag テーブルへ登録する
     * 既存のタグはすべて削除した上で再登録する
     *
     * @param  array  $tags  例: [['tag_id' => 'xxx'], ['tag_id' => 'yyy']]
     */
    public function syncTags(string $routineId, array $tags): void
    {
        DB::transaction(function () use ($routineId, $tags) {
            // 既存の routine_tag を削除
            $this->routineTagRepository->deleteAllByRoutineId($routineId);

            // 新しいタグを登録
            foreach ($tags as $tag) {
                if (empty($tag['tag_id'])) {
                    Log::warning('タグIDが空のためスキップされました', ['routine_id' => $routineId]);

                    continue;
                }

                $this->routineTagRepository->create([
                    'routine_tag_id' => UuidService::generateV7(),
                    'routine_id' => $routineId,
                    'tag_id' => $tag['tag_id'],
                    'created_at' => now(),
                ]);
            }
        });
    }
}
