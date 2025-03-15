<?php

namespace Modules\Carts\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            // 'cartable_id' => $this->customer_id,
            // 'cartable_type' => $this->customer_type,
            "user" => user(),
            "address" => $this->whenLoaded("address", $this->address),
            "coupon" => $this->whenLoaded("coupon", $this->coupon),
            "totals" => $this->totals,
            "items" => $this->whenLoaded(
                "items",
                CartItemResource::collection($this->items)
            ),
        ];
    }
}
