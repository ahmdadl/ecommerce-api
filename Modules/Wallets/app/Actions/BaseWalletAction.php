<?php

namespace Modules\Wallets\Actions;

use Modules\Core\Exceptions\ApiException;
use Modules\Wallets\Services\WalletService;

abstract class BaseWalletAction
{
    public WalletService $walletService;

    public function __construct()
    {
        $this->walletService = walletService();
    }

    public static function new(): static
    {
        return new static();
    }

    /**
     * validate non negative amount
     */
    protected function validateNonNegativeAmount(float $amount): void
    {
        if ($amount <= 0) {
            throw new ApiException(__("wallets::t.amount_must_be_positive"));
        }
    }

    /**
     * validate amount is gt other number
     */
    protected function validateAmountGte(
        float $amount,
        float $other,
        string $otherName
    ): void {
        if ($amount < $other) {
            $otherName = __($otherName . "_amount");

            throw new ApiException(
                __("wallets::t.amount_must_be_gte", [
                    "other_name" => $otherName,
                ])
            );
        }
    }

    /**
     * validate amount is lt other number
     */
    protected function validateAmountLte(
        float $amount,
        float $other,
        string $otherName
    ): void {
        if ($amount > $other) {
            $otherName = __($otherName . "_amount");

            throw new ApiException(
                __("wallets::t.amount_must_be_lte", [
                    "other_name" => $otherName,
                ])
            );
        }
    }
}
