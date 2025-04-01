<?php

namespace Modules\Wishlists\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->wishlistable_id,
            // 'user_type' => $this->wishlistable_type,
            // "user" => $this->whenLoaded("wishlistable", $this->wishlistable),
            "items" => WishlistItemResource::collection(
                $this->whenLoaded("items", $this->items)
            ),
        ];
    }
}
