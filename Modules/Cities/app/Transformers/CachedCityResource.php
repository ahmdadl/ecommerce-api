<?php

namespace Modules\Cities\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CachedCityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "government_id" => $this->government_id,
            "title" => $this->getTranslations("title"),
        ];
    }
}
