<?php

namespace Modules\Payments\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Wallets\Transformers\WalletTransactionResource;

class PaymentAttemptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "payable_id" => $this->payable_id,
            "payable_type" => $this->payable_type,
            "payment_method" => $this->payment_method,
            "status" => $this->status,
            "payment_details" => $this->payment_details,
            "payable" => $this->whenLoaded("payable"),
            "wallet_transaction" => new WalletTransactionResource(
                $this->whenLoaded("walletTransaction")
            ),
        ];
    }
}
