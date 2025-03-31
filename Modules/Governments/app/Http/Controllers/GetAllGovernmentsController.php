<?php

namespace Modules\Governments\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Governments\Models\Government;
use Modules\Governments\Transformers\GovernmentResource;

class GetAllGovernmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(): JsonResponse
    {
        return api()->records(
            GovernmentResource::collection(
                Government::active()->paginateIfRequested()
            )
        );
    }
}
