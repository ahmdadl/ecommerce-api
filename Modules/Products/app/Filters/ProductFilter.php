<?php

namespace Modules\Products\Filters;

use Modules\Categories\Models\Category;
use Modules\Core\Filters\ModelFilter;

class ProductFilter extends ModelFilter
{
    // Filter by category_id
    public function category(string $value)
    {
        return $this->builder->where("category_id", $value);
    }

    // Filter by category slug
    public function categorySlug(string $value)
    {
        return $this->builder->whereRelation("category", "slug", $value);
    }

    // Filter by brand_id
    public function brand(string $value)
    {
        return $this->builder->where("brand_id", $value);
    }

    // Filter by brand slug
    public function brandSlug(string $value)
    {
        return $this->builder->whereRelation("brand", "slug", $value);
    }

    // Filter by tag id
    public function tag(string $value)
    {
        return $this->builder->whereRelation("tags", "tag_id", $value);
    }

    // Filter by tag slug
    public function tagSlug(string $value)
    {
        return $this->builder->whereRelation("tags", "slug", $value);
    }

    // Filter by title (assuming JSON field search)
    public function title(string $value)
    {
        return $this->builder
            ->where("title->en", "like", "%$value%")
            ->orWhere("title->ar", "like", "%$value%");
    }

    // Filter by sku
    public function sku(string $value)
    {
        return $this->builder->where("sku", $value);
    }

    // Filter by price range
    public function min_price(float $value)
    {
        return $this->builder->where("price", ">=", $value);
    }

    public function max_price(float $value)
    {
        return $this->builder->where("price", "<=", $value);
    }

    // Filter by sale price range
    public function min_sale_price(float $value)
    {
        return $this->builder->where("sale_price", ">=", $value);
    }

    public function max_sale_price(float $value)
    {
        return $this->builder->where("sale_price", "<=", $value);
    }

    // Filter by stock availability
    public function in_stock(bool $value)
    {
        return $this->builder->where("stock", $value ? ">" : "<=", 0);
    }

    // Filter by is_main
    public function is_main(bool $value)
    {
        return $this->builder->where("is_main", $value);
    }

    /**
     * filter by categories
     */
    public function categories(array $value)
    {
        return $this->builder->whereIn("category_id", $value);
    }

    /**
     * filter by brands
     */
    public function brands(array $value)
    {
        return $this->builder->whereIn("brand_id", $value);
    }

    public function price(string $value)
    {
        $priceRange = explode("-", $value);

        return $this->builder->whereBetween("sale_price", $priceRange);
    }

    /**
     * filter by tags
     */
    public function tags(array $value)
    {
        return $this->builder->whereHas("tags", function ($query) use ($value) {
            $query->whereIn("tag_id", $value);
        });
    }

    /**
     * search by multiple fields
     */
    public function searchQuery(string $value)
    {
        return $this->builder
            ->where(function ($query) use ($value) {
                $query
                    ->where("title->en", "like", "%$value%")
                    ->orWhere("title->ar", "like", "%$value%");
            })
            ->orWhere("sku", "like", "%$value%")
            ->orWhere("slug", $value)
            ->orWhere("id", $value);
    }

    /**
     * {@inheritDoc}
     */
    protected function getAllowedFilters(): array
    {
        return [
            "category" => "string",
            "categorySlug" => "string",
            "brand" => "string",
            "brandSlug" => "string",
            "tag" => "string",
            "tagSlug" => "string",
            "title" => "string",
            "min_price" => "float",
            "max_price" => "float",
            "min_sale_price" => "float",
            "max_sale_price" => "float",
            "in_stock" => "boolean",
            "is_main" => "boolean",
            "sku" => "string",
            "created_at" => "date",
            "categories" => "array",
            "brands" => "array",
            "price" => "string",
            "tags" => "array",
            "searchQuery" => "string",
        ];
    }
}
