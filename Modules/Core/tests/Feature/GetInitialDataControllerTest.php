<?php

use Modules\Carts\Models\Cart;
use Modules\Carts\Models\CartItem;
use Modules\Guests\Models\Guest;
use Modules\Users\Models\User;
use Modules\Wishlists\Models\Wishlist;
use Modules\Wishlists\Models\WishlistItem;

it("gets_guest_initial_data", function () {
    $guest = Guest::factory()->create();
    $cart = Cart::factory()->for($guest, "cartable")->create();
    CartItem::factory()->for($cart)->count(3)->create();

    $wishlist = Wishlist::factory()->for($guest, "wishlistable")->create();
    WishlistItem::factory()->for($wishlist)->count(2)->create();

    $guest->refresh();
    expect($guest->cart->id)->toBe($cart->id);
    expect($guest->cart->items()->count())->toBe(3);
    expect($guest->wishlist->id)->toBe($wishlist->id);
    expect($guest->wishlist->items()->count())->toBe(2);

    asGuest($guest)
        ->getJson(route("api.user-initial-data"))
        ->assertOk()
        ->assertSee($guest->cart->id)
        ->assertSee($guest->cart->items()->first()->id)
        ->assertSee($guest->wishlist->id)
        ->assertSee($guest->wishlist->items()->first()->id);
});

it("gets_user_initial_data", function () {
    $user = User::factory()->customer()->create();
    $cart = Cart::factory()->for($user, "cartable")->create();
    CartItem::factory()->for($cart)->count(3)->create();

    $wishlist = Wishlist::factory()->for($user, "wishlistable")->create();
    WishlistItem::factory()->for($wishlist)->count(2)->create();

    $user->refresh();
    expect($user->cart->id)->toBe($cart->id);
    expect($user->cart->items()->count())->toBe(3);
    expect($user->wishlist->id)->toBe($wishlist->id);
    expect($user->wishlist->items()->count())->toBe(2);

    asCustomer($user)
        ->getJson(route("api.user-initial-data"))
        ->assertOk()
        ->assertSee($user->cart->id)
        ->assertSee($user->cart->items()->first()->id)
        ->assertSee($user->wishlist->id)
        ->assertSee($user->wishlist->items()->first()->id);
});
