<?php

namespace Modules\Wallets\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Payments\Transformers\PaymentMethodResource;

class WalletTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "amount" => $this->amount,
            "type" => $this->type,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "notes" => $this->notes,
            "formatted_date" => $this->created_at->format("Y-m-d H:i:s a"),
            "payment_method" => $this->whenNotNull(
                $this->payment_method,
                fn() => new PaymentMethodResource($this->paymentMethodRecord)
            ),
        ];
    }
}
