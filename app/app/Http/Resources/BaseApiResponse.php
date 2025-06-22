<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseApiResponse extends JsonResource
{
    /**
     * 共通APIレスポンス形式
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'code' => $this->resource['code'] ?? 200,
            'message' => $this->resource['message'] ?? 'OK',
            'data' => $this->resource['data'] ?? null,
        ];
    }
}
