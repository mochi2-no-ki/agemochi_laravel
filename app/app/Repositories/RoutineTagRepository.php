<?php

namespace App\Repositories;

use App\Models\RoutineTag;

class RoutineTagRepository extends BaseRepository
{
    /**
     * コンストラクタ：RoutineTagモデルを注入
     */
    public function __construct(RoutineTag $routineTag)
    {
        parent::__construct($routineTag);
    }

    // 必要であればRoutineTag特有の処理をここに追加
    /**
     * 指定されたルーティーンIDに紐づく routine_tag をすべて削除する
     */
    public function deleteAllByRoutineId(string $routineId): void
    {
        $this->baseQuery()
            ->where('routine_id', $routineId)
            ->delete();
    }
}
