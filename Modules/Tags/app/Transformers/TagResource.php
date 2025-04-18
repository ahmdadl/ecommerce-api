<?php

namespace Modules\Tags\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Products\Transformers\ProductResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            // 'is_active' => $this->is_active,
            "products_count" => $this->whenCounted("products"),
            // "products" => ProductResource::collection(
            //     $this->whenLoaded("products")
            // ),
        ];
    }
}
