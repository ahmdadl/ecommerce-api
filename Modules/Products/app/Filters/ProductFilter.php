<?php

namespace Modules\Products\Filters;

use Modules\Core\Filters\ModelFilter;

class ProductFilter extends ModelFilter
{
    // Filter by category_id
    public function category(string $value)
    {
        return $this->builder->where("category_id", $value);
    }

    // Filter by brand_id
    public function brand(string $value)
    {
        return $this->builder->where("brand_id", $value);
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
        return $this->builder->where("salePrice", ">=", $value);
    }

    public function max_sale_price(float $value)
    {
        return $this->builder->where("salePrice", "<=", $value);
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

        return $this->builder->whereBetween("salePrice", $priceRange);
    }

    /**
     * {@inheritDoc}
     */
    protected function getAllowedFilters(): array
    {
        return [
            "category" => "string",
            "brand" => "string",
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
        ];
    }
}
