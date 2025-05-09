<?php

use Modules\Core\Exceptions\ApiException;
use Modules\Payments\Models\PaymentMethod;
use Modules\Users\Models\User;
use Modules\Wallets\Actions\ValidateWalletAmountAction;
use Modules\Wallets\Actions\WalletCreditAction;
use Modules\Wallets\Actions\WalletCreditCompleteAction;
use Modules\Wallets\Actions\WalletDebitAction;
use Modules\Wallets\Exceptions\InsufficientBalanceException;

use function Pest\Laravel\withoutExceptionHandling;

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

test("action validate wallet amount non negative", function () {
    walletService()->fullyCredit(100, $this->createdBy);
    $action = new ValidateWalletAmountAction();

    $this->expectException(ApiException::class);

    expect($action->handle(0));
});

test("action validate wallet amount greater than available", function () {
    walletService()->fullyCredit(100, $this->createdBy);
    $action = new ValidateWalletAmountAction();

    $this->expectException(ApiException::class);

    expect($action->handle(101));
});
