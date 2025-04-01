<?php

namespace Modules\CompareLists\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\CompareLists\Models\CompareListItem;
use Modules\CompareLists\Services\CompareListService;
use Modules\CompareLists\Transformers\CompareListResource;
use Modules\Products\Models\Product;
use Modules\CompareLists\Actions\AddToCompareListAction;

class CompareListsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(
        Request $request,
        CompareListService $service
    ): JsonResponse {
        $compareList = $service->compareList;
        $compareList->loadMissing(["items", "items.product"]);
        $compareList->unsetRelation("compareListable");
        return api()->record(new CompareListResource($compareList));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        Request $request,
        Product $product,
        AddToCompareListAction $action
    ): JsonResponse {
        $action->handle($product);
        return $this->index($request, $action->service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        CompareListItem $compareListItem
    ): JsonResponse {
        compareListService()->removeItem($compareListItem);
        return $this->index($request, compareListService());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function clear(Request $request): JsonResponse
    {
        compareListService()->clear();
        return $this->index($request, compareListService());
    }
}
