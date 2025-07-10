<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\ListTagRequest;
use App\Http\Resources\BaseApiResponse;
use App\Http\Resources\Tag\TagResource;
use App\Services\Tag\TagService;

class TagController extends Controller
{
    protected TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * タグ名を曖昧検索して最大8件を返す
     */
    public function list(ListTagRequest $request)
    {
        $search = $request->input('search');
        $tags = $this->tagService->getListBySearch($search);

        return response()->json(new BaseApiResponse([
            'code' => 200,
            'message' => 'OK',
            'data' => [
                'tags' => TagResource::collection($tags),
            ],
        ]));
    }
}
