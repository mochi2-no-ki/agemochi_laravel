<?php

namespace App\Http\Resources\Routine;

use Illuminate\Http\Resources\Json\JsonResource;

class RoutineListResource extends JsonResource
{
    /**
     * リスト用ルーティーン整形
     */
    public function toArray($request): array
    {
        return [
            'routine_id' => $this->routine_id,
            'routine_title' => $this->routine_title,
            'routine_time' => $this->routine_time,
            'tags' => optional($this->routineTags)->map(function ($routineTag) {
                return ['tag_name' => optional($routineTag->tag)->tag_name];
            }) ?? [],
            'user' => [
                'mochi_id' => optional($this->userAccount)->mochi_id,
                'user_name' => optional($this->userAccount)->user_name,
                'user_img_path' => optional($this->userAccount)->user_img_path,
            ],
            'reference_count' => $this->reference_count,
            'routine_save_count' => $this->routine_saves_count,
        ];
    }
}
