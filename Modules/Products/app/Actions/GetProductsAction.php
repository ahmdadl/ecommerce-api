<?php

namespace Modules\Products\Actions;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Core\Traits\HasActionHelpers;
use Modules\Products\Filters\ProductFilter;
use Modules\Products\Models\Product;
use Modules\Products\Transformers\ProductResource;

class GetProductsAction
{
    use HasActionHelpers;

    public function handle(Request $request)
    {
        $products = Product::query()
            ->active()
            ->filter(new ProductFilter($request))
            ->with($this->getLazyLoadRelations($request));

        $response = [];

        $request->when(
            $request->has("withFilters"),
            fn() => ($response["filters"] = GetProductFiltersAction::new(
                clone $products
            )->handle())
        );

        $products = $products->paginate();
        $response["records"] = ProductResource::collection($products);
        $response["paginationInfo"] = $this->getPaginationInfo($products);

        return $response;
    }

    /**
     * get lazy load relations
     * @return string[]
     */
    private function getLazyLoadRelations(Request $request): array
    {
        $with = [];
        if ($request->has("withCategory")) {
            $with[] = "category";
        }

        if ($request->has("withBrand")) {
            $with[] = "brand";
        }

        return $with;
    }

    /**
     * get pagination info
     */
    private function getPaginationInfo(LengthAwarePaginator $products): object
    {
        return (object) [
            "current_page" => $products->currentPage(),
            "per_page" => $products->perPage(),
            "total" => $products->total(),
            "last_page" => $products->lastPage(),
            "from" => $products->firstItem(),
            "to" => $products->lastItem(),
            "has_more_pages" => $products->hasMorePages(),
        ];
    }
}
