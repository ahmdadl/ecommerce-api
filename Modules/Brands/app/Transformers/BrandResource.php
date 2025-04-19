<?php

namespace Modules\Brands\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Products\Transformers\ProductResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $image = "https::/picsum.photos/seed/$this->id/600/600";

        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "slug" => $this->slug,
            "image" => $image,
            "is_main" => $this->is_main,
            "sort_order" => $this->sort_order,
            // "is_active" => $this->is_active,
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "meta_keywords" => $this->meta_keywords,
            "products_count" => $this->whenCounted("products"),
            "products" => ProductResource::collection(
                $this->whenLoaded("products")
            ),
        ];
    }
}
