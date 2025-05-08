<?php

use Modules\Core\Exceptions\ApiException;
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

    $action->handle(100, $this->createdBy);

    expect(walletService()->getBalance()->pending)->toBeFloat(100);
});

test("action can complete credit wallet", function () {
    $action = new WalletCreditAction();

    $action->handle(100, $this->createdBy);

    $action = new WalletCreditCompleteAction();

    $action->handle(100, $this->createdBy);

    expect(walletService()->getBalance()->pending)->toBeFloat(0);
    expect(walletService()->getBalance()->available)->toBeFloat(100);
});

test("action can debit wallet", function () {
    // First, credit and complete to have available balance
    $creditAction = new WalletCreditAction();
    $creditAction->handle(200, $this->createdBy);

    $completeAction = new WalletCreditCompleteAction();
    $completeAction->handle(200, $this->createdBy);

    $debitAction = new WalletDebitAction();
    $debitAction->handle(50, $this->createdBy);

    expect(walletService()->getBalance()->available)->toBeFloat(150);
});

test("action cannot debit wallet with insufficient balance", function () {
    $action = new WalletDebitAction();

    expect(fn() => $action->handle(100, $this->createdBy))->toThrow(
        ApiException::class
    );
});

test("action cannot credit wallet with negative amount", function () {
    $action = new WalletCreditAction();

    expect(fn() => $action->handle(-50, $this->createdBy))->toThrow(
        ApiException::class,
        "Amount must be positive"
    );
});

test("action cannot complete credit with negative amount", function () {
    $action = new WalletCreditCompleteAction();

    expect(fn() => $action->handle(-50, $this->createdBy))->toThrow(
        ApiException::class,
        "Amount must be positive"
    );
});

test("action cannot debit wallet with negative amount", function () {
    $action = new WalletDebitAction();

    expect(fn() => $action->handle(-50, $this->createdBy))->toThrow(
        ApiException::class,
        "Amount must be positive"
    );
});

test("action can handle multiple credit and debit transactions", function () {
    // Credit and complete
    $creditAction = new WalletCreditAction();
    $creditAction->handle(300, $this->createdBy);

    $completeAction = new WalletCreditCompleteAction();
    $completeAction->handle(300, $this->createdBy);

    // Debit
    $debitAction = new WalletDebitAction();
    $debitAction->handle(100, $this->createdBy);

    // Another credit
    $creditAction->handle(200, $this->createdBy);
    $completeAction->handle(200, $this->createdBy);

    expect(walletService()->getBalance()->available)->toBeFloat(400);
    expect(walletService()->getBalance()->pending)->toBeFloat(0);
});

test("action preserves balance integrity with concurrent credits", function () {
    $action = new WalletCreditAction();

    // Simulate concurrent credits
    $action->handle(100, $this->createdBy);
    $action->handle(200, $this->createdBy);

    expect(walletService()->getBalance()->pending)->toBeFloat(300);

    $completeAction = new WalletCreditCompleteAction();
    $completeAction->handle(300, $this->createdBy);

    expect(walletService()->getBalance()->pending)->toBeFloat(0);
    expect(walletService()->getBalance()->available)->toBeFloat(300);
});
