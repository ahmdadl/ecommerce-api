<?php

namespace Modules\Categories\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Products\Transformers\ProductResource;

class CategoryResource extends JsonResource
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
            "image" => $this->image,
            "is_main" => $this->is_main,
            "sort_order" => $this->sort_order,
            // "is_active" => $this->is_active,
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "meta_keywords" => $this->meta_keywords,
            "products_count" => $this->whenNotNull("products_count"),
            // "created_at" => $this->created_at,
            // "updated_at" => $this->updated_at,
            "products" => ProductResource::collection(
                $this->whenLoaded("products")
            ),
        ];
    }
}
