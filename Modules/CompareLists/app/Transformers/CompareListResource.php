<?php

namespace Modules\CompareLists\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompareListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            // "user" => $this->whenLoaded("user", $this->user),
            "items" => CompareListItemResource::collection(
                $this->whenLoaded("items", $this->items)
            ),
        ];
    }
}
