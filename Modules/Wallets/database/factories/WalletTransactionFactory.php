<?php

namespace Modules\Wallets\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Users\Models\User;
use Modules\Wallets\Enums\WalletTransactionStatus;
use Modules\Wallets\Enums\WalletTransactionType;
use Modules\Wallets\Models\Wallet;

class WalletTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Wallets\Models\WalletTransaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "wallet_id" => fn() => Wallet::factory(),
            "created_by" => fn() => User::factory()->customer(),
            "amount" => fake()->numberBetween(1, 100),
            "type" => fake()->randomElement(WalletTransactionType::cases())
                ->value,
            "status" => WalletTransactionStatus::PENDING,
            "notes" => fake()->boolean() ? null : fake()->sentence(),
        ];
    }
}
