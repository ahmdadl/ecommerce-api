<?php

use Modules\Core\Exceptions\ApiException;
use Modules\Payments\Models\PaymentMethod;
use Modules\Users\Models\User;
use Modules\Wallets\Actions\WalletCreditAction;
use Modules\Wallets\Actions\WalletCreditCompleteAction;
use Modules\Wallets\Actions\WalletDebitAction;
use Modules\Wallets\Exceptions\InsufficientBalanceException;

beforeEach(function () {
    $this->user = User::factory()->customer()->create();
    auth()->setUser($this->user);
    $this->createdBy = User::factory()->create();
});

test("action can credit wallet", function () {
    $action = new WalletCreditAction();

    $action->handle(100, PaymentMethod::active()->first());

    expect(walletService()->getBalance()->pending)->toBeFloat(100);
});
