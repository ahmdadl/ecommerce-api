<?php

namespace Modules\Carts\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Carts\ValueObjects\CartTotals;
use Modules\Guests\Models\Guest;
use Modules\Users\Models\User;

/**
 * @extends Factory<\Modules\Carts\Models\Cart>
 *
 * @mixin Factory<\Modules\Carts\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Carts\Models\Cart::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "cartable_id" => fn() => User::factory(),
            "cartable_type" => User::class,
            "address_id" => null,
            "coupon_id" => null,
            "totals" => CartTotals::default(),
        ];
    }

    /**
     * Indicate that the model's cartable should be guest
     */
    public function byGuest(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "cartable_id" => fn() => Guest::factory(),
                "cartable_type" => Guest::class,
            ]
        );
    }
}
