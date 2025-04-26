<?php

namespace Modules\Terms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Terms\Transformers\TermResource;

class GetTermsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(): JsonResponse
    {
        $terms = cache()->rememberForever(
            "api_terms",
            fn() => \Modules\Terms\Models\Term::active()
                ->orderBySortOrderAsc()
                ->get()
        );

        return api()->records(TermResource::collection($terms));
    }
}
