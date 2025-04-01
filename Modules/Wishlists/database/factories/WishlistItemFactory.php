<?php

namespace Modules\Wishlists\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WishlistItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Wishlists\Models\WishlistItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "wishlist_id" => fn() => \Modules\Wishlists\Models\Wishlist::factory(),
            "product_id" => fn() => \Modules\Products\Models\Product::factory(),
        ];
    }
}
