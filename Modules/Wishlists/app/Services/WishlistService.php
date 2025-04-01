<?php

namespace Modules\Wishlists\Services;

use Illuminate\Support\Facades\DB;
use Modules\Products\Models\Product;
use Modules\Wishlists\Models\Wishlist;
use Modules\Wishlists\Models\WishlistItem;

final readonly class WishlistService
{
    /**
     * Initializes the CartService with a Cart instance and calls the init method.
     */
    public function __construct(public Wishlist $wishlist)
    {
        //
    }

    /**
     * Adds a specified quantity of a product to the wishlist, creating a new CartItem entry in the database.
     */
    public function addItem(Product $product): void
    {
        DB::transaction(function () use ($product) {
            WishlistItem::create([
                "wishlist_id" => $this->wishlist->id,
                "product_id" => $product->id,
            ]);

            $this->save();
        });
    }

    /**
     * Removes a specified CartItem from the wishlist.
     */
    public function removeItem(WishlistItem $wishlistItem): void
    {
        DB::transaction(function () use ($wishlistItem) {
            $this->wishlist->items()->where("id", $wishlistItem->id)->delete();
        });
    }

    /**
     * save wishlist
     */
    private function save(): void
    {
        $this->wishlist->save();
    }
}
