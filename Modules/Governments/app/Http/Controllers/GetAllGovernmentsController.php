<?php

namespace Modules\Governments\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Governments\Models\Government;
use Modules\Governments\Transformers\GovernmentResource;

class GetAllGovernmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(): JsonResponse
    {
        /** @var LengthAwarePaginator|Collection */
        $governments = Government::active()->paginateIfRequested();

        return api()->paginatedIfRequested(
            $governments,
            GovernmentResource::class
        );
    }
}
