<?php

namespace Modules\PageViews\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\PageViews\Actions\CreatePageViewAction;
use Modules\PageViews\Enums\ViewableType;
use Modules\PageViews\Http\Requests\CreatePageViewRequest;
use Modules\Products\Models\Product;
use Modules\Tags\Models\Tag;

class CreatePageViewController extends Controller
{
    public function __invoke(
        CreatePageViewRequest $request,
        CreatePageViewAction $action
    ): JsonResponse {
        /** @var Request $request */

        $action->handle(
            $request->enum("type", ViewableType::class),
            $request->str("slug")->value(),
            $request->str("user_agent")->value(),
            $request->headers->all(),
            $request->user(),
            $request->ip(),
            $request->str("page")->value()
        );

        return api()->noContent();
    }
}
