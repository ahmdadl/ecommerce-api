<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $products = Product::query()
            ->filter(new ProductFilter($request))
            ->active();

        $with = [];

        if ($request->has("withCategory")) {
            $with[] = "category";
        }

        if ($request->has("withBrand")) {
            $with[] = "brand";
        }

        if (count($with) > 0) {
            $products->with($with);
        }

        return api()->records(ProductResource::collection($products->get()));
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request, Product $product): JsonResponse
    {
        if ($request->has("withCategory")) {
            $product->loadMissing("category");
        }

        if ($request->has("withBrand")) {
            $product->loadMissing("brand");
        }

        return api()->record(new ProductResource($product));
    }
}
