<?php

namespace Modules\Carts\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "cart" => $this->whenLoaded("cart", $this->cart),
            "product" => $this->whenLoaded("product", $this->product),
            "quantity" => $this->quantity,
            "totals" => $this->totals,
        ];
    }
}
