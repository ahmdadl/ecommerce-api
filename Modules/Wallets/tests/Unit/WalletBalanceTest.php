<?php

use Modules\Wallets\ValueObjects\WalletBalance;

it("can credit the balance", function () {
    $balance = WalletBalance::default();
    $balance = $balance->credit(100);
    expect($balance->available)->toBe((float) 100);
    expect($balance->pending)->toBe((float) 0);
    expect($balance->total)->toBe((float) 100);
});

it("can debit the balance", function () {
    $balance = WalletBalance::default();

    $balance = $balance->credit(100);
    expect($balance->available)->toBe((float) 100);
    expect($balance->pending)->toBe((float) 0);
    expect($balance->total)->toBe((float) 100);

    $balance = $balance->debit(100);
    expect($balance->available)->toBe((float) 0);
    expect($balance->pending)->toBe((float) 0);
    expect($balance->total)->toBe((float) 0);
});

it("can credit pending balance", function () {
    $balance = WalletBalance::default();
    $balance = $balance->creditPending(100);
    expect($balance->available)->toBe((float) 0);
    expect($balance->pending)->toBe((float) 100);
    expect($balance->total)->toBe((float) 100);
});

it("can debit pending balance", function () {
    $balance = new WalletBalance(100, 0, 100);

    $balance = $balance->debitPending(40);
    expect($balance->available)->toBe((float) 60);
    expect($balance->pending)->toBe((float) 40);
    expect($balance->total)->toBe((float) 100);
});

it("can complete pending credit balance", function () {
    $balance = WalletBalance::default();

    $balance = $balance->creditPending(100);
    expect($balance->available)->toBe((float) 0);
    expect($balance->pending)->toBe((float) 100);
    expect($balance->total)->toBe((float) 100);

    $balance = $balance->completePendingCredit(100);
    expect($balance->available)->toBe((float) 100);
    expect($balance->pending)->toBe((float) 0);
    expect($balance->total)->toBe((float) 100);
});

it("can cancel pending credit balance", function () {
    $balance = WalletBalance::default();

    $balance = $balance->creditPending(100);
    expect($balance->available)->toBe((float) 0);
    expect($balance->pending)->toBe((float) 100);
    expect($balance->total)->toBe((float) 100);

    $balance = $balance->cancelPendingCredit(100);
    expect($balance->available)->toBe((float) 0);
    expect($balance->pending)->toBe((float) 0);
    expect($balance->total)->toBe((float) 0);
});

it("can complete pending debit balance", function () {
    $balance = new WalletBalance(100, 0, 100);

    $balance = $balance->debitPending(40);
    expect($balance->available)->toBe((float) 60);
    expect($balance->pending)->toBe((float) 40);
    expect($balance->total)->toBe((float) 100);

    $balance = $balance->completePendingDebit(40);
    expect($balance->available)->toBe((float) 60);
    expect($balance->pending)->toBe((float) 0);
    expect($balance->total)->toBe((float) 60);
});

it("can cancel pending debit balance", function () {
    $balance = new WalletBalance(100, 0, 100);

    $balance = $balance->debitPending(40);
    expect($balance->available)->toBe((float) 60);
    expect($balance->pending)->toBe((float) 40);
    expect($balance->total)->toBe((float) 100);

    $balance = $balance->cancelPendingDebit(40);
    expect($balance->available)->toBe((float) 100);
    expect($balance->pending)->toBe((float) 0);
    expect($balance->total)->toBe((float) 100);
});

test("wallet_balance_full", function () {
    $balance = WalletBalance::default();

    $balance = $balance->credit(100);
    expect($balance->available)->toBe((float) 100);
    expect($balance->pending)->toBe((float) 0);
    expect($balance->total)->toBe((float) 100);

    $balance = $balance->debit(50);
    expect($balance->available)->toBe((float) 50);
    expect($balance->pending)->toBe((float) 0);
    expect($balance->total)->toBe((float) 50);

    $balance = $balance->creditPending(100);
    expect($balance->available)->toBe((float) 50);
    expect($balance->pending)->toBe((float) 100);
    expect($balance->total)->toBe((float) 150);

    $balance = $balance->completePendingCredit(100);
    expect($balance->available)->toBe((float) 150);
    expect($balance->pending)->toBe((float) 0);
    expect($balance->total)->toBe((float) 150);

    $balance = $balance->debitPending(60);
    expect($balance->available)->toBe((float) 90);
    expect($balance->pending)->toBe((float) 60);
    expect($balance->total)->toBe((float) 150);

    $balance = $balance->completePendingDebit(60);
    expect($balance->available)->toBe((float) 90);
    expect($balance->pending)->toBe((float) 0);
    expect($balance->total)->toBe((float) 90);

    $balance = $balance->creditPending(90);
    expect($balance->available)->toBe((float) 90);
    expect($balance->pending)->toBe((float) 90);
    expect($balance->total)->toBe((float) 180);

    $balance = $balance->debitPending(50);
    expect($balance->available)->toBe((float) 40);
    expect($balance->pending)->toBe((float) 140);
    expect($balance->total)->toBe((float) 180);

    $balance = $balance->completePendingCredit(90);
    expect($balance->available)->toBe((float) 130);
    expect($balance->pending)->toBe((float) 50);
    expect($balance->total)->toBe((float) 180);
});
