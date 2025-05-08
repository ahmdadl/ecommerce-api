<?php

namespace Modules\Wallets\Actions;

use Modules\Users\Models\User;

class WalletDebitCancelAction extends BaseWalletAction
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

        $this->walletService->cancelDebit($amount, $createdBy, $notes);
    }
}
