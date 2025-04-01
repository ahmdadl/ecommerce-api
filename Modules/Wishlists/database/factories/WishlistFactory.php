<?php

namespace Modules\Wishlists\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;

class WishlistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Wishlists\Models\Wishlist::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "wishlistable_id" => fn() => User::factory()->customer(),
            "wishlistable_type" => Customer::class,
        ];
    }
}
