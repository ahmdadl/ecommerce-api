<?php

namespace Modules\Wallets\Services;

use Illuminate\Support\Facades\DB;
use Modules\Core\Exceptions\ApiException;
use Modules\Users\Models\User;
use Modules\Wallets\Enums\WalletTransactionStatus;
use Modules\Wallets\Enums\WalletTransactionType;
use Modules\Wallets\Models\Wallet;
use Modules\Wallets\Models\WalletTransaction;
use Modules\Wallets\ValueObjects\WalletBalance;

class WalletService
{
    public function __construct(public readonly Wallet $wallet)
    {
        //
    }

    /**
     * add pending credit
     */
    public function credit(
        float $amount,
        User $createdBy,
        ?string $notes = null
    ): WalletTransaction {
        return DB::transaction(function () use ($amount, $createdBy, $notes) {
            $this->wallet->balance = $this->wallet->balance->creditPending(
                $amount
            );
            $this->wallet->save();

            return $this->wallet->transactions()->create([
                "amount" => $amount,
                "type" => WalletTransactionType::CREDIT,
                "status" => WalletTransactionStatus::PENDING,
                "notes" => $notes,
                "created_by" => $createdBy->id,
            ]);
        });
    }

    /**
     * add pending debit
     */
    public function debit(float $amount, User $createdBy, ?string $notes = null)
    {
        DB::transaction(function () use ($amount, $createdBy, $notes) {
            $this->wallet->balance = $this->wallet->balance->debitPending(
                $amount
            );
            $this->wallet->save();

            $this->wallet->transactions()->create([
                "amount" => $amount,
                "type" => WalletTransactionType::DEBIT,
                "status" => WalletTransactionStatus::PENDING,
                "notes" => $notes,
                "created_by" => $createdBy->id,
            ]);
        });
    }

    /**
     * complete pending credit
     */
    public function completeCredit(
        float $amount,
        User $createdBy,
        ?string $notes = null
    ): void {
        DB::transaction(function () use ($amount, $createdBy, $notes) {
            $this->wallet->balance = $this->wallet->balance->completePendingCredit(
                $amount
            );
            $this->wallet->save();

            $this->wallet->transactions()->create([
                "amount" => $amount,
                "type" => WalletTransactionType::CREDIT,
                "status" => WalletTransactionStatus::COMPLETED,
                "notes" => $notes,
                "created_by" => $createdBy->id,
            ]);
        });
    }

    /**
     * cancel pending credit
     */
    public function cancelCredit(
        float $amount,
        User $createdBy,
        ?string $notes = null
    ): void {
        DB::transaction(function () use ($amount, $createdBy, $notes) {
            $this->wallet->balance = $this->wallet->balance->cancelPendingCredit(
                $amount
            );
            $this->wallet->save();

            $this->wallet->transactions()->create([
                "amount" => $amount,
                "type" => WalletTransactionType::CREDIT,
                "status" => WalletTransactionStatus::CANCELED,
                "notes" => $notes,
                "created_by" => $createdBy->id,
            ]);
        });
    }

    /**
     * complete pending debit
     */
    public function completeDebit(
        float $amount,
        User $createdBy,
        ?string $notes = null
    ): void {
        DB::transaction(function () use ($amount, $createdBy, $notes) {
            $this->wallet->balance = $this->wallet->balance->completePendingDebit(
                $amount
            );
            $this->wallet->save();

            $this->wallet->transactions()->create([
                "amount" => $amount,
                "type" => WalletTransactionType::DEBIT,
                "status" => WalletTransactionStatus::COMPLETED,
                "notes" => $notes,
                "created_by" => $createdBy->id,
            ]);
        });
    }

    /**
     * cancel pending debit
     */
    public function cancelDebit(
        float $amount,
        User $createdBy,
        ?string $notes = null
    ): void {
        DB::transaction(function () use ($amount, $createdBy, $notes) {
            $this->wallet->balance = $this->wallet->balance->cancelPendingDebit(
                $amount
            );
            $this->wallet->save();

            $this->wallet->transactions()->create([
                "amount" => $amount,
                "type" => WalletTransactionType::DEBIT,
                "status" => WalletTransactionStatus::CANCELED,
                "notes" => $notes,
                "created_by" => $createdBy->id,
            ]);
        });
    }

    /**
     * add fully completed credit
     */
    public function fullyCredit(
        float $amount,
        User $createdBy,
        ?string $notes = null
    ): void {
        DB::transaction(function () use ($amount, $createdBy, $notes) {
            $this->wallet->balance = $this->wallet->balance->credit($amount);
            $this->wallet->save();

            $this->wallet->transactions()->create([
                "amount" => $amount,
                "type" => WalletTransactionType::CREDIT,
                "status" => WalletTransactionStatus::COMPLETED,
                "notes" => $notes,
                "created_by" => $createdBy->id,
            ]);
        });
    }

    /**
     * add fully completed debit
     */
    public function fullyDebit(
        float $amount,
        User $createdBy,
        ?string $notes = null
    ): void {
        DB::transaction(function () use ($amount, $createdBy, $notes) {
            $this->wallet->balance = $this->wallet->balance->debit($amount);
            $this->wallet->save();

            $this->wallet->transactions()->create([
                "amount" => $amount,
                "type" => WalletTransactionType::DEBIT,
                "status" => WalletTransactionStatus::COMPLETED,
                "notes" => $notes,
                "created_by" => $createdBy->id,
            ]);
        });
    }

    /**
     * get wallet balance
     */
    public function getBalance(): WalletBalance
    {
        return $this->wallet->balance;
    }

    /**
     * create new instance
     */
    public static function create(User $user): self
    {
        return new self(
            $user->wallet ??
                $user->wallet()->create([
                    "balance" => WalletBalance::default(),
                ])
        );
    }

    /**
     * create new instance for current user
     */
    public static function createForCurrentUser(): self
    {
        if (!user() || user()->isGuest) {
            throw new ApiException(__("wallets::t.user_not_logged_in"));
        }

        return self::create(user());
    }
}
