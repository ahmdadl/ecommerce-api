<?php

namespace Modules\Addresses\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "government_id" => $this->government_id,
            "city_id" => $this->city_id,
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "title" => $this->title,
            "address" => $this->address,
            "phoneNumber" => $this->phoneNumber,
            "government" => $this->whenLoaded("government", $this->government),
            "city" => $this->whenLoaded("city", $this->city),
        ];
    }
}
