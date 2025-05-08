<?php

namespace Modules\Wallets\Actions;

use Modules\Users\Models\User;

class WalletCreditAction extends BaseWalletAction
{
    public function handle(
        float $amount,
        User $createdBy,
        ?string $notes = null
    ) {
        $this->validateNonNegativeAmount($amount);

        $this->walletService->credit($amount, $createdBy, $notes);
    }
}
