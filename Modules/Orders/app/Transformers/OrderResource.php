<?php

namespace Modules\Orders\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "address_id" => $this->address_id,
            "status" => __("orders::t.status." . $this->status->value),
            "payment_status" => __(
                "orders::t.payment_status." . $this->payment_status->value
            ),
            "payment_method" => $this->paymentMethodRecord->name,
            "totals" => $this->totals,
            "created_at" => $this->created_at,
            "user" => $this->whenLoaded("user"),
            "items" => OrderItemResource::collection(
                $this->whenLoaded("items")
            ),
            "address" => $this->whenLoaded("address"),
            "coupon" => $this->whenLoaded("coupon"),
            "paymentAttempts" => $this->whenLoaded("paymentAttempts"),
        ];
    }
}
