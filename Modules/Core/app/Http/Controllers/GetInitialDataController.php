<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Actions\GetInitialDataAction;

class GetInitialDataController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request,
        GetInitialDataAction $action
    ): JsonResponse {
        $response = $action->handle($request->user());

        return api()->success($response);
    }
}
