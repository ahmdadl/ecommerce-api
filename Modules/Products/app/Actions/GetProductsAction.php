<?php

namespace Modules\Products\Actions;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Brands\Models\Brand;
use Modules\Brands\Transformers\BrandResource;
use Modules\Categories\Models\Category;
use Modules\Categories\Transformers\CategoryResource;
use Modules\Core\Exceptions\ApiException;
use Modules\Core\Traits\HasActionHelpers;
use Modules\Products\Filters\ProductFilter;
use Modules\Products\Models\Product;
use Modules\Products\Transformers\ProductResource;
use Modules\Tags\Models\Tag;
use Modules\Tags\Transformers\TagResource;

class GetProductsAction
{
    use HasActionHelpers;

    public function handle(Request $request)
    {
        user()->loadMissing(["cartItems", "wishlistItems"]);

        $productsQuery = Product::query()
            ->active()
            ->filter(new ProductFilter($request))
            ->with($this->getLazyLoadRelations($request))
            ->orderBy(...$this->getOrderBy($request));

        $perPage = $request->integer("perPage", 15);

        $response = [];

        $productsQueryClone = clone $productsQuery;

        $products = $productsQuery->paginate($perPage);
        $response["records"] = ProductResource::collection($products);
        $response["paginationInfo"] = $this->getPaginationInfo($products);

        if ($request->boolean("withFilters")) {
            $response["filters"] = GetProductFiltersAction::new(
                $productsQueryClone
            )->handle();
        }

        if ($request->has("forCategory")) {
            $response["category"] = new CategoryResource(
                Category::active()
                    ->where("slug", $request->string("forCategory")->value())
                    ->firstOrFail()
            );
        }

        if ($request->has("forBrand")) {
            $response["brand"] = new BrandResource(
                Brand::active()
                    ->where("slug", $request->string("forBrand")->value())
                    ->firstOrFail()
            );
        }

        if ($request->has("forTag")) {
            $response["tag"] = new TagResource(
                Tag::active()
                    ->where("slug", $request->string("forTag")->value())
                    ->firstOrFail()
            );
        }

        return $response;
    }

    /**
     * get lazy load relations
     * @return string[]
     */
    private function getLazyLoadRelations(Request $request): array
    {
        $relations = [];

        if ($request->boolean("withCategory")) {
            $relations[] = "category";
        }

        if ($request->boolean("withBrand")) {
            $relations[] = "brand";
        }

        return $relations;
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

    /**
     * get order by
     * @return string[]
     */
    private function getOrderBy(Request $request): array
    {
        $orderBy = ["id", "desc"];

        if ($sortBy = $request->has("sortBy")) {
            $orderBy = match ($request->string("sortBy")->value()) {
                // "lowest_price" => ["sale_price", "asc"],
                // "highest_price" => ["sale_price", "desc"],
                // "lowest_stock" => ["stock", "asc"],
                "newest" => ["id", "desc"],
                "oldest" => ["id", "asc"],
                default => ["id", "desc"],
            };
        }

        return $orderBy;
    }
}
