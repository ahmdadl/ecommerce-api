<?php

namespace Modules\Wallets\Actions;

use Modules\Users\Models\User;

class WalletDebitAction extends BaseWalletAction
{
    public function handle(
        float $amount,
        User $createdBy,
        ?string $notes = null
    ) {
        $this->validateNonNegativeAmount($amount);

        $this->validateAmountLte(
            $amount,
            $this->walletService->getBalance()->available,
            "available"
        );

        $this->walletService->debit($amount, $createdBy, $notes);
    }
}
