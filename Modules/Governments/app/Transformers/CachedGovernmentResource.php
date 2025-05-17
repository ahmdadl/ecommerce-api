<?php

namespace Modules\Governments\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Cities\Transformers\CachedCityResource;

class CachedGovernmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->getTranslations("title"),
            "shipping_fees" => $this->shipping_fees ?? 0,
            "cities" => CachedCityResource::collection(
                $this->whenLoaded("cities")
            ),
        ];
    }
}
