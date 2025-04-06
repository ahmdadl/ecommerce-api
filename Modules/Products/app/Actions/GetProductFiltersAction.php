<?php

namespace Modules\Products\Actions;

use Modules\Core\Traits\HasActionHelpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Products\Models\Product;
use Modules\Categories\Models\Category;
use Modules\Brands\Models\Brand;

class GetProductFiltersAction
{
    use HasActionHelpers;

    /**
     * Initialize
     * @param Builder<Product> $builder
     */
    public function __construct(public Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Get available filters based on current query
     * @return array
     */
    public function handle()
    {
        return [
            "categories" => $this->getCategories(),
            "brands" => $this->getBrands(),
            "price_range" => $this->getPriceRange(),
        ];
    }

    /**
     * Get available categories
     * @return \Illuminate\Support\Collection
     */
    protected function getCategories()
    {
        // $categoryIds = $this->builder->pluck("category_id")->unique();

        $productCounts = $this->builder
            ->clone()
            ->select("category_id")
            ->selectRaw("COUNT(*) as products_count")
            ->groupBy("category_id")
            ->pluck("products_count", "category_id");

        return Category::select("id", "title", "slug")
            ->active()
            ->get()
            ->map(function ($category) use ($productCounts) {
                return [
                    "id" => $category->id,
                    "title" => $category->title,
                    "slug" => $category->slug,
                    "products_count" => $productCounts[$category->id] ?? 0,
                ];
            });
    }

    /**
     * Get available brands
     * @return \Illuminate\Support\Collection
     */
    protected function getBrands()
    {
        $brandIds = $this->builder->clone()->pluck("brand_id")->unique();

        $productCounts = $this->builder
            ->clone()
            ->select("brand_id")
            ->selectRaw("COUNT(*) as products_count")
            ->groupBy("brand_id")
            ->pluck("products_count", "brand_id");

        return Brand::whereIn("id", $brandIds)
            ->select("id", "title", "slug")
            ->active()
            ->get()
            ->map(function ($brand) use ($productCounts) {
                return [
                    "id" => $brand->id,
                    "title" => $brand->title,
                    "slug" => $brand->slug,
                    "products_count" => $productCounts[$brand->id] ?? 0,
                ];
            });
    }

    /**
     * Get price range
     * @return array
     */
    protected function getPriceRange()
    {
        $stats = Product::query()
            ->selectRaw("MIN(price) as min_price, MAX(price) as max_price")
            ->first();

        return [
            "min" => $stats->min_price ?? 0,
            "max" => $stats->max_price ?? 0,
        ];
    }

    /**
     * get dependency injection instance
     */
    public static function new(Builder $builder): static
    {
        return app(static::class, ["builder" => $builder]);
    }
}
