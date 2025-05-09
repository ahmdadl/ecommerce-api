<?php

namespace Modules\Wallets\Actions;

class ValidateWalletAmountAction extends BaseWalletAction
{
    public function handle(float $amount)
    {
        $this->validateNonNegativeAmount($amount);

        $this->validateAmountLte(
            $amount,
            $this->walletService->getBalance()->available,
            __("wallets::t.available_amount")
        );

        return $amount;
    }
}
