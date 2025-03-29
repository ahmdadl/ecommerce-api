<?php

namespace Modules\Brands\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Brands\Models\Brand;
use Modules\Brands\Transformers\BrandResource;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $brands = Brand::withCount("products")->active()->get();

        return api()->records(BrandResource::collection($brands));
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request, Brand $brand): JsonResponse
    {
        if ($request->has("withProducts")) {
            $brand->loadMissing("products");
        }
        return api()->record(new BrandResource($brand));
    }
}
