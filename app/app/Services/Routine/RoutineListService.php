<?php

namespace App\Services\Routine;

use App\Repositories\RoutineRepository;

class RoutineListService
{
    protected RoutineRepository $routineRepository;

    public function __construct(RoutineRepository $routineRepository)
    {
        $this->routineRepository = $routineRepository;
    }

    /**
     * クエリパラメータに基づいてルーティーン一覧を取得する
     *
     * @return \Illuminate\Support\Collection
     */
    public function getListByConditions(array $params)
    {
        // BaseRepository から取得したクエリビルダを起点に条件構築
        $query = $this->routineRepository->baseQuery()
            ->with(['routineTags', 'userAccount'])
            ->withCount('routineSaves')
            ->join('routine_view', 'routine.routine_id', '=', 'routine_view.routine_id')
            ->addSelect('routine.*', 'routine_view.reference_count');

        // search：タイトル or タグ名
        if (! empty($params['search']) && is_array($params['search'])) {
            foreach ($params['search'] as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('routine_title', 'like', '%'.$term.'%')
                        ->orWhereHas('routineTags', function ($tagQ) use ($term) {
                            $tagQ->where('tag_name', 'like', '%'.$term.'%');
                        });
                });
            }
        }

        // rr：リアルタイムルーティーンフラグ
        if (isset($params['rr'])) {
            $query->where('realtime_routine_flag', $params['rr']);
        }

        // 所要時間（分）
        if (! empty($params['time'])) {
            $query->where('routine_time', '<=', $params['time']);
        }

        // 開始時間
        if (! empty($params['start'])) {
            $query->whereTime('routine_start', '>=', $params['start'].':00');
        }

        // 終了時間
        if (! empty($params['end'])) {
            $query->whereTime('routine_end', '<=', $params['end'].':00');
        }

        // 投稿者 mochi_id 絞り込み
        if (! empty($params['user'])) {
            $query->whereHas('userAccount', function ($q) use ($params) {
                $q->where('mochi_id', $params['user']);
            });
        }

        // ソート（ランダムは未対応：将来的に最適化の上で導入予定）
        match ($params['sort'] ?? 'desc') {
            // 月ごとのランダムや、重複のないランダムは今後の展望
            'random' => $query->inRandomOrder(),
            'asc' => $query->orderBy('routine.created_at', 'asc'),
            'desc' => $query->orderBy('routine.created_at', 'desc'),
            default => $query->orderBy('routine.created_at', 'desc'), // 明示的に分ける！
        };

        // オフセット＋10件取得
        $offset = $params['offset'] ?? 0;

        return $query->offset($offset)->limit(10)->get();
    }
}
