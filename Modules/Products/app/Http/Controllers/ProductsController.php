<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Products\Actions\GetProductFilters;
use Modules\Products\Actions\GetProductsAction;
use Modules\Products\Filters\ProductFilter;
use Modules\Products\Models\Product;
use Modules\Products\Transformers\ProductResource;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return api()->success(GetProductsAction::new()->handle($request));
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request, Product $product): JsonResponse
    {
        $request->whenHas(
            "withCategory",
            fn() => $product->loadMissing("category")
        );

        $request->whenHas("withBrand", fn() => $product->loadMissing("brand"));

        $request->whenHas("withTags", fn() => $product->loadMissing("tags"));

        $record = new ProductResource($product);

        $relatedProducts = Product::where("category_id", $product->category_id)
            ->where("id", "!=", $product->id)
            ->inRandomOrder()
            ->limit(7)
            ->get();
        $relatedProducts = ProductResource::collection($relatedProducts);

        return api()->success(compact("record", "relatedProducts"));
    }
}
