<?php

namespace Modules\Wallets\Actions;

use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Payments\Enums\PaymentAttemptType;
use Modules\Payments\Models\PaymentMethod;
use Modules\Users\Models\User;

class WalletCreditAction extends BaseWalletAction
{
    public function handle(
        float $amount,
        PaymentMethod $paymentMethod,
        ?string $receipt = null,
        ?string $notes = null
    ) {
        $this->validateNonNegativeAmount($amount);

        $transaction = $this->walletService->credit(
            $amount,
            user(),
            $paymentMethod->code,
            $notes
        );

        $paymentAttempt = $transaction->paymentAttempts()->create([
            "payment_method" => $paymentMethod->code,
            "receipt" => $receipt,
            "status" => OrderPaymentStatus::PENDING,
            "type" => PaymentAttemptType::WALLET,
        ]);

        if (!$paymentMethod->is_online) {
            return api()->record(GetWalletAction::new()->handle());
        }

        if ($paymentMethod->is_online) {
            return api()->success([
                "payment_url" => route("payments.index", $paymentAttempt->id),
            ]);
        }

        return api()->error();
    }
}
