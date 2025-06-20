<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository extends BaseRepository
{
    /**
     * コンストラクタ：Tagモデルを注入
     */
    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }

    // 必要であればTag特有の処理をここに追加
}
