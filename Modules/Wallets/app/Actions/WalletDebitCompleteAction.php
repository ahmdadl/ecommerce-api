<?php

namespace Modules\Wallets\Actions;

use Modules\Users\Models\User;

class WalletDebitCompleteAction extends BaseWalletAction
{
    public function handle(
        float $amount,
        User $createdBy,
        ?string $notes = null
    ) {
        $this->validateNonNegativeAmount($amount);

        $this->validateAmountLte(
            $amount,
            $this->walletService->getBalance()->pending,
            "pending"
        );

        $this->validateAmountLte(
            $amount,
            $this->walletService->getBalance()->total,
            "total"
        );

        $this->walletService->completeDebit($amount, $createdBy, $notes);
    }
}
