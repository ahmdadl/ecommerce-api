<?php

namespace Modules\Guests\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            "totals" => $this->totals,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'access_token' => $this->when(isset($this->access_token), $this->access_token),

        ];
    }
}
