<?php

use Illuminate\Support\Facades\DB;
use Modules\Carts\Models\Cart;
use Modules\Carts\Models\CartItem;
use Modules\Users\Enums\UserRole;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;
use Modules\Users\ValueObjects\UserTotals;
use Modules\Wishlists\Models\Wishlist;
use Modules\Wishlists\Models\WishlistItem;

it("user_have_columns_by_default", function () {
    $userFactory = User::factory()->customer()->make();

    $user = Customer::create([
        ...$userFactory->only(["name", "email", "password"]),
    ]);

    expect($user->totals)->toBeInstanceOf(UserTotals::class);
    expect($user->role)->toBe(UserRole::CUSTOMER);
    expect($user->is_active)->toBeTrue();
});

test("user_has_many_wishlist_items", function () {
    $user = User::factory()->customer()->create();

    $wishlist = Wishlist::factory()->for($user, "wishlistable")->create();
    WishlistItem::factory()->for($wishlist)->create();

    expect($user->wishlist()->count())->toBe(1);
    expect($user->wishlistItems()->count())->toBe(1);
});

test("user_has_many_cart_items", function () {
    $user = User::factory()->customer()->create();

    $cart = Cart::factory()->for($user, "cartable")->create();
    CartItem::factory()->for($cart)->create();

    expect($user->cart()->count())->toBe(1);
    expect($user->cartItems()->count())->toBe(1);
});
