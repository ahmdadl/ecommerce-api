<?php

use Modules\Core\Exceptions\ApiException;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;
use Modules\Wishlists\Actions\AddToWishlistAction;
use Modules\Wishlists\Models\WishlistItem;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    // Create a fresh product for each test
    $this->product = Product::factory()->create();

    actingAs(User::factory()->customer()->create());

    $this->addAction = AddToWishlistAction::new();
});

it("successfully adds product to wishlist", function () {
    $this->addAction->handle($this->product);

    expect(wishlistService()->hasProduct($this->product))->toBeTrue();
});

it("throws exception when wishlist is full", function () {
    WishlistItem::factory()
        ->for($this->addAction->service->wishlist, "wishlist")
        ->count(10)
        ->create();

    expect(fn() => $this->addAction->handle($this->product))->toThrow(
        ApiException::class,
        __("wishlists::t.wishlist_is_full")
    );
});

it("throws exception when product already exists in wishlist", function () {
    WishlistItem::factory()->create([
        "wishlist_id" => $this->addAction->service->wishlist->id,
        "product_id" => $this->product->id,
    ]);

    expect(fn() => $this->addAction->handle($this->product))->toThrow(
        ApiException::class,
        __("wishlists::t.product_already_in_wishlist")
    );
});

it("successfully removes product from wishlist", function () {
    $wishlistItem = WishlistItem::factory()->create([
        "wishlist_id" => $this->addAction->service->wishlist->id,
        "product_id" => $this->product->id,
    ]);

    wishlistService()->removeItem($wishlistItem);

    expect(wishlistService()->hasProduct($this->product))->toBeFalse();

    assertDatabaseMissing("wishlist_items", [
        "product_id" => $this->product->id,
        "wishlist_id" => $this->addAction->service->wishlist->id,
    ]);
});

it("successfully clears wishlist", function () {
    WishlistItem::factory()->create([
        "wishlist_id" => $this->addAction->service->wishlist->id,
        "product_id" => $this->product->id,
    ]);

    wishlistService()->clear();

    expect(wishlistService()->hasProduct($this->product))->toBeFalse();

    assertDatabaseMissing("wishlist_items", [
        "product_id" => $this->product->id,
        "wishlist_id" => $this->addAction->service->wishlist->id,
    ]);
});
