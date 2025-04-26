<?php

namespace Modules\Terms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
                ->orderBySortOrder()
                ->get()
        );

        return api()->records(
            \Modules\Terms\Transformers\TermResource::collection($terms)
        );
    }
}
