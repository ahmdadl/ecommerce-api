<?php

namespace Modules\Governments\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Governments\Models\Government;
use Modules\Governments\Transformers\GovernmentResource;

class GovernmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $governments = Government::query()->active();

        if (request()->has("paginate")) {
            $governments = $governments->paginate();
        } else {
            $governments = $governments->get();
        }

        return api()->records(GovernmentResource::collection($governments));
    }
}
