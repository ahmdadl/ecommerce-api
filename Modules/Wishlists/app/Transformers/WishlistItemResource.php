<?php

namespace Modules\Wishlists\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Products\Transformers\ProductResource;

class WishlistItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "wishlist_id" => $this->wishlist_id,
            "product_id" => $this->product_id,
            "product" => new ProductResource(
                $this->whenLoaded("product", $this->product)
            ),
            // "created_at" => $this->created_at,
        ];
    }
}
