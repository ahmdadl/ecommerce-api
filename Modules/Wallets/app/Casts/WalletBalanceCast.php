<?php

namespace Modules\Wallets\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\Wallets\ValueObjects\WalletBalance;

class WalletBalanceCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(
        Model $model,
        string $key,
        mixed $value,
        array $attributes
    ): WalletBalance {
        // @phpstan-ignore-next-line
        if (!json_validate($value)) {
            throw new \Exception("Wallet balance value is invalid JSON format");
        }

        // @phpstan-ignore-next-line
        return WalletBalance::fromArray(json_decode($value, true));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(
        Model $model,
        string $key,
        mixed $value,
        array $attributes
    ): string {
        if (!$value instanceof WalletBalance) {
            throw new InvalidArgumentException(
                "The provided value is not an instance of WalletBalance."
            );
        }

        // @phpstan-ignore-next-line
        return json_encode($value->toArray());
    }
}
