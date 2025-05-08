<?php

namespace Modules\Wallets\Actions;

use Modules\Users\Models\User;

class WalletCreditCompleteAction extends BaseWalletAction
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
            __("wallets::t.pending")
        );

        $this->walletService->completeCredit($amount, $createdBy, $notes);
    }
}
