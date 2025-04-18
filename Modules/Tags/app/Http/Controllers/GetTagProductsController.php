<?php

namespace Modules\Tags\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Tags\Models\Tag;

class GetTagProductsController extends Controller
{
    public function __invoke(Request $request, Tag $tag): JsonResponse
    {
        $tag->loadMissing("products");

        return api()->record($tag);
    }
}
