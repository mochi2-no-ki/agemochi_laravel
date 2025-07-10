<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * タグ一覧取得用の整形処理
     */
    public function toArray($request): array
    {
        return [
            'tag_id' => $this->tag_id,
            'tag_name' => $this->tag_name,
        ];
    }
}
