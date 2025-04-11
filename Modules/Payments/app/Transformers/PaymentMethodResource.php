<?php

namespace Modules\Payments\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "code" => $this->code,
            "name" => $this->name,
            "image" => $this->imageUrl,
        ];
    }
}
