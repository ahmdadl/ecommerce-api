<?php

namespace Modules\Wallets\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "balance" => $this->balance,
            "transactions" => WalletTransactionResource::collection(
                $this->whenLoaded("transactions")
            ),
        ];
    }
}
