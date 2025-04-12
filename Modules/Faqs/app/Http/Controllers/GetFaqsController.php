<?php

namespace Modules\Faqs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Faqs\Models\FaqCategory;
use Modules\Faqs\Transformers\FaqCategoryResource;

class GetFaqsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $faqs = FaqCategory::with([
            "faqs" => function ($query) {
                $query->active();
            },
        ])
            ->active()
            ->get();

        return api()->records(FaqCategoryResource::collection($faqs));
    }
}
