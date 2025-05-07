<?php

namespace Modules\Wallets\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Users\Models\User;
use Modules\Wallets\ValueObjects\WalletBalance;

class WalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Wallets\Models\Wallet::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "user_id" => fn() => User::factory()->customer(),
            "balance" => WalletBalance::default(),
            "is_active" => true,
        ];
    }

    public function unActive(): self
    {
        return $this->state([
            "is_active" => false,
        ]);
    }
}
