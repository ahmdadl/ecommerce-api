<?php

use Modules\Guests\Models\Guest;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;
use Modules\Wishlists\Models\Wishlist;
use Modules\Wishlists\Models\WishlistItem;
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

it("has_count_method", function () {
    $wishlist = Wishlist::factory()->create();

    $wishlistService = new WishlistService($wishlist);

    expect($wishlistService->count())->toBe(0);
});

it("has_has_product_method", function () {
    $wishlist = Wishlist::factory()->create();
    $product = Product::factory()->create();

    $wishlistService = new WishlistService($wishlist);

    expect($wishlistService->hasProduct($product))->toBe(false);

    $wishlistService->addItem($product);

    expect($wishlistService->hasProduct($product))->toBe(true);
});

it("has_is_empty_wishlist_method", function () {
    $wishlist = Wishlist::factory()->create();

    $wishlistService = new WishlistService($wishlist);

    expect($wishlistService->isEmpty())->toBe(true);
});

it("has_clear_wishlist_method", function () {
    $wishlist = Wishlist::factory()->create();

    $wishlistService = new WishlistService($wishlist);

    $wishlistService->addItem(Product::factory()->create());

    expect($wishlistService->isEmpty())->toBe(false);

    $wishlistService->clear();

    expect($wishlistService->isEmpty())->toBe(true);
});

it("updates_user_total_wishlist_items", function () {
    $user = User::factory()->customer()->create();
    $wishlist = Wishlist::factory()->for($user, "wishlistable")->create();
    $wishlistService = new WishlistService($wishlist);

    $wishlistService->addItem(Product::factory()->create());

    $user->refresh();
    expect($user->totals->wishlistItems)->toBe(1);
    expect($wishlistService->count())->toBe(1);

    $wishlistService->removeItem(WishlistItem::first());

    expect($wishlistService->count())->toBe(0);
    $user->refresh();
    expect($user->totals->wishlistItems)->toBe(0);

    $wishlistService->addItem(Product::factory()->create());
    $wishlistService->addItem(Product::factory()->create());

    $user->refresh();
    expect($user->totals->wishlistItems)->toBe(2);

    $wishlistService->clear();

    $user->refresh();
    expect($user->totals->wishlistItems)->toBe(0);
});

it("updates_guest_total_wishlist_items", function () {
    $user = Guest::factory()->create();
    $wishlist = Wishlist::factory()->for($user, "wishlistable")->create();
    $wishlistService = new WishlistService($wishlist);

    $wishlistService->addItem(Product::factory()->create());

    $user->refresh();
    expect($user->totals->wishlistItems)->toBe(1);
    expect($wishlistService->count())->toBe(1);

    $wishlistService->removeItem(WishlistItem::first());

    expect($wishlistService->count())->toBe(0);
    $user->refresh();
    expect($user->totals->wishlistItems)->toBe(0);

    $wishlistService->addItem(Product::factory()->create());
    $wishlistService->addItem(Product::factory()->create());

    $user->refresh();
    expect($user->totals->wishlistItems)->toBe(2);

    $wishlistService->clear();

    $user->refresh();
    expect($user->totals->wishlistItems)->toBe(0);
});
