<?php

namespace Modules\Tags\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Products\Actions\GetProductsAction;
use Modules\Tags\Models\Tag;
use Modules\Tags\Transformers\TagResource;

class GetTagProductsController extends Controller
{
    public function __invoke(Request $request, Tag $tag): JsonResponse
    {
        $request->merge(["tagSlug" => $tag->slug]);

        return api()->success([
            "tag" => new TagResource($tag),
            ...GetProductsAction::new()->handle($request),
        ]);
    }
}
