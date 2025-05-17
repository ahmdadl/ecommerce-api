<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Actions\GetSsrCachedDataAction;

class GetSsrCachedDataController extends Controller
{
    public function __invoke(
        Request $request,
        GetSsrCachedDataAction $action
    ): JsonResponse {
        return api()->success($action->handle());
    }
}
