<?php

namespace Modules\Carts\Actions;

use Modules\Core\Exceptions\ApiException;
use Modules\Wallets\Actions\ValidateWalletAmountAction;

class ApplyWalletAmountForCartAction extends BaseCartAction
{
    public function handle(float $amount)
    {
        ValidateWalletAmountAction::new()->handle($amount);

        $cartTotalAmount = $this->service->getTotals()->total;

        if ($amount > $cartTotalAmount) {
            $amount = $cartTotalAmount;
        }

        $this->service->setWalletAmount($amount);
    }
}
