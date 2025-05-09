<?php

use Modules\Users\Models\User;
use Modules\Wallets\Enums\WalletTransactionStatus;
use Modules\Wallets\Models\Wallet;
use Modules\Wallets\Services\WalletService;
use Modules\Wallets\ValueObjects\WalletBalance;

beforeEach(function () {
    $this->wallet = Wallet::factory()->create();
    $this->createdBy = User::factory()->create();
    $this->service = new WalletService($this->wallet);
});

it("can get balance", function () {
    /** @var WalletService $service */
    $service = $this->service;

    expect($service->getBalance())->toBeInstanceOf(WalletBalance::class);
});

test("service can credit the balance pending", function () {
    /** @var WalletService $service */
    $service = $this->service;

    $service->credit(100, $this->createdBy, null);

    expect($service->wallet->balance->available)->toBeFloat(0);
    expect($service->wallet->balance->pending)->toBeFloat(100);
    expect($service->wallet->balance->total)->toBeFloat(100);

    expect($service->wallet->transactions()->count())->toBe(1);
});

test("service can confirm pending balance", function () {
    /** @var WalletService $service */
    $service = $this->service;

    $service->credit(100, $this->createdBy, null);
    expect($service->wallet->balance->pending)->toBeFloat(100);

    $service->completeCredit(100, $this->createdBy);

    expect($service->wallet->balance->available)->toBeFloat(100);
    expect($service->wallet->balance->pending)->toBeFloat(0);
    expect($service->wallet->balance->total)->toBeFloat(100);

    expect($service->wallet->transactions()->count())->toBe(2);
});

test("service can cancel pending balance", function () {
    /** @var WalletService $service */
    $service = $this->service;

    $service->credit(100, $this->createdBy, null);
    expect($service->wallet->balance->pending)->toBeFloat(100);

    $service->cancelCredit(100, $this->createdBy);

    expect($service->wallet->balance->available)->toBeFloat(0);
    expect($service->wallet->balance->pending)->toBeFloat(0);
    expect($service->wallet->balance->total)->toBeFloat(0);

    expect($service->wallet->transactions()->count())->toBe(2);
});

test("service can debit the balance pending", function () {
    /** @var WalletService $service */
    $service = $this->service;

    $service->fullyCredit(100, $this->createdBy);
    expect($service->wallet->balance->available)->toBeFloat(100);

    $service->debit(40, $this->createdBy);

    expect($service->wallet->balance->available)->toBeFloat(60);
    expect($service->wallet->balance->pending)->toBeFloat(40);
    expect($service->wallet->balance->total)->toBeFloat(message: 100);

    expect($service->wallet->transactions()->count())->toBe(2);
});

test("service can confirm pending debit balance", function () {
    /** @var WalletService $service */
    $service = $this->service;

    $service->fullyCredit(100, $this->createdBy);
    expect($service->wallet->balance->available)->toBeFloat(100);

    $service->debit(60, $this->createdBy);
    $service->completeDebit(60, $this->createdBy);

    expect($service->wallet->balance->available)->toBeFloat(40);
    expect($service->wallet->balance->pending)->toBeFloat(0);
    expect($service->wallet->balance->total)->toBeFloat(40);

    expect($service->wallet->transactions()->count())->toBe(3);
});

test("service can cancel pending debit balance", function () {
    /** @var WalletService $service */
    $service = $this->service;

    $service->fullyCredit(100, $this->createdBy);
    expect($service->wallet->balance->available)->toBeFloat(100);

    $service->debit(60, $this->createdBy);
    $service->cancelDebit(60, $this->createdBy);

    expect($service->wallet->balance->available)->toBeFloat(100);
    expect($service->wallet->balance->pending)->toBeFloat(0);
    expect($service->wallet->balance->total)->toBeFloat(100);

    expect($service->wallet->transactions()->count())->toBe(3);
});

test("service fully cycle", function () {
    /** @var WalletService $service */
    $service = $this->service;

    $service->fullyCredit(100, $this->createdBy);
    expect($service->wallet->balance->available)->toBeFloat(100);

    $service->fullyDebit(30, $this->createdBy);
    expect($service->wallet->balance->available)->toBeFloat(70);

    $service->credit(50, $this->createdBy, null);
    $service->completeCredit(50, $this->createdBy);
    expect($service->wallet->balance->available)->toBeFloat(120);

    $service->fullyDebit(20, $this->createdBy);
    expect($service->wallet->balance->available)->toBeFloat(100);

    $service->debit(30, $this->createdBy);
    $service->completeDebit(30, $this->createdBy);
    expect($service->wallet->balance->available)->toBeFloat(70);
});

it("has helper function", function () {
    $user = User::factory()->customer()->create();

    // will create wallet
    $service = walletService(false, $user);
    expect($service->wallet->user_id)->toBe($user->id);

    $wallet = Wallet::factory()->create();
    auth()->setUser($wallet->user);
    // it will use existing wallet
    $service = walletService();
    expect($service->wallet->user_id)->toBe($wallet->user_id);

    // wont create wallet
    $service = walletService();
    expect($service->wallet->user_id)->toBe($wallet->user_id);

    expect(Wallet::count())->toBe(3); // one from before each test
});
