<?php

namespace Modules\Governments\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Cities\Transformers\CityResource;

class GovernmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "shipping_fees" => $this->shipping_fees ?? 0,
            "cities" => CityResource::collection($this->whenLoaded("cities")),
        ];
    }
}
