<?php

use Modules\Products\Models\Product;
use Modules\Users\Models\User;
use Modules\Wishlists\Models\Wishlist;
use Modules\Wishlists\Services\WishlistService;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

it("can_add_product_to_wishlist", function () {
    $wishlist = Wishlist::factory()->create();
    $product = Product::factory()->create();

    $wishlistService = new WishlistService($wishlist);
    $wishlistService->addItem($product);

    expect($wishlist->items()->count())->toBe(1);

    assertDatabaseHas("wishlist_items", [
        "wishlist_id" => $wishlist->id,
        "product_id" => $product->id,
    ]);
});

it("can_remove_product_from_wishlist", function () {
    $wishlist = Wishlist::factory()->create();
    $product = Product::factory()->create();

    $wishlistService = new WishlistService($wishlist);
    $wishlistService->addItem($product);

    expect($wishlist->items()->count())->toBe(1);

    $wishlistService->removeItem($wishlist->items()->first());

    expect($wishlist->items()->count())->toBe(0);

    assertDatabaseMissing("wishlist_items", [
        "wishlist_id" => $wishlist->id,
        "product_id" => $product->id,
    ]);
});

test("wishlist_is_created_directly_for_current_user", function () {
    actingAs(User::factory()->customer()->create());

    $wishlistService = app(WishlistService::class);

    expect($wishlistService->wishlist)->toBeInstanceOf(Wishlist::class);

    assertDatabaseHas("wishlists", [
        "wishlistable_id" => user()->id,
        "wishlistable_type" => get_class(user()),
    ]);
});

it("has_wishlist_helper_method", function () {
    actingAs(User::factory()->customer()->create());

    expect(wishlistService())->toBeInstanceOf(WishlistService::class);
});
