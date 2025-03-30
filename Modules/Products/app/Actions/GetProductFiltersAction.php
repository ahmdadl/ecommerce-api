<?php

namespace Modules\Products\Actions;

use Modules\Core\Traits\HasActionHelpers;
use Illuminate\Database\Eloquent\Builder;
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
        $categoryIds = $this->builder->pluck("category_id")->unique();

        return Category::whereIn("id", $categoryIds)
            ->select("id", "title", "slug")
            ->active()
            ->withCount("products")
            ->get()
            ->map(function ($category) {
                return [
                    "id" => $category->id,
                    "title" => $category->title,
                    "slug" => $category->slug,
                    "products_count" => $category->products_count,
                ];
            });
    }

    /**
     * Get available brands
     * @return \Illuminate\Support\Collection
     */
    protected function getBrands()
    {
        $brandIds = $this->builder->pluck("brand_id")->unique();

        return Brand::whereIn("id", $brandIds)
            ->select("id", "title", "slug")
            ->active()
            ->withCount("products")
            ->get()
            ->map(function ($brand) {
                return [
                    "id" => $brand->id,
                    "title" => $brand->title,
                    "slug" => $brand->slug,
                    "products_count" => $brand->products_count,
                ];
            });
    }

    /**
     * Get price range
     * @return array
     */
    protected function getPriceRange()
    {
        $stats = $this->builder
            ->selectRaw("MIN(price) as min_price, MAX(price) as max_price")
            ->first();

        return [
            "min" => $stats->min_price,
            "max" => $stats->max_price,
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
