<?php

namespace Modules\Orders\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "coupon_id" => $this->coupon_id,
            "code" => $this->code,
            "name" => $this->name,
            "discount_type" => $this->discount_type,
            "value" => $this->value,
        ];
    }
}
