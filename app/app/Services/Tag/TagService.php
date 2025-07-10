<?php

namespace App\Services\Tag;

use App\Repositories\TagRepository;
use Illuminate\Support\Collection;

class TagService
{
    protected TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * 検索条件に応じてタグを取得する
     */
    public function getListBySearch(?string $search): Collection
    {
        $query = $this->tagRepository->baseQuery();

        // SoftDeletes対応：削除されていないものに限定
        $query->whereNull('deleted_at');

        if (! empty($search)) {
            $query->where('tag_name', 'like', '%'.$search.'%');
        } else {
            $query->inRandomOrder();
        }

        return $query->limit(8)->get();
    }
}
