<?php

namespace Modules\Products\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Brands\Transformers\BrandResource;
use Modules\Categories\Transformers\CategoryResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "slug" => $this->slug,
            "is_main" => $this->is_main,
            "images" => collect($this->images)->map("uploads_url"),
            "price" => $this->price,
            "sale_price" => $this->salePrice,
            "is_discounted" => $this->isDiscounted,
            "discounted_price" => $this->discountedPrice,
            "stock" => $this->stock,
            "has_stock" => $this->hasStock,
            "sku" => $this->sku,
            // "is_active" => $this->is_active,
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "meta_keywords" => $this->meta_keywords,
            "category" => new CategoryResource($this->whenLoaded("category")), // Relationship
            "brand" => new BrandResource($this->whenLoaded("brand")),
        ];
    }
}
