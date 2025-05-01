<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Banners\Models\Banner;
use Modules\Banners\Transformers\BannerResource;
use Modules\Brands\Models\Brand;
use Modules\Brands\Transformers\BrandResource;
use Modules\Categories\Models\Category;
use Modules\Categories\Transformers\CategoryResource;
use Modules\Products\Models\Product;
use Modules\Products\Transformers\ProductResource;

class GetHomeController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $banners = cache()->rememberForever(
            "banners_" . app()->getLocale(),
            fn() => BannerResource::collection(
                Banner::with("actionable")
                    ->active()
                    ->orderBySortOrderAsc()
                    ->get()
            )
        );

        $bestSellers = cache()->rememberForever(
            "best-sellers_" . app()->getLocale(),
            fn() => ProductResource::collection(
                Product::active()
                    ->withSum("orderItems", "quantity")
                    ->orderByDesc("order_items_sum_quantity")
                    ->orderByDesc("stock")
                    ->limit(8)
                    ->get()
            )
        );

        return api()->success(compact("banners", "bestSellers"));
    }
}
