<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phoneNumber' => $this->phoneNumber,
            'totals' => $this->totals,
            'gender' => $this->gender,
            'created_at' => $this->created_at,
            'role' => $this->when(isset($this->withRole), $this->role),
            'access_token' => $this->whenNotNull($this->access_token),
        ];
    }
}
