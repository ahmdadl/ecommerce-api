<?php

use Modules\Carts\Models\Cart;
use Modules\Guests\Models\Guest;
use Modules\Users\Models\User;

test("user_can_have_cart", function () {
    $user = User::factory()->customer()->create();

    $cart = Cart::factory()->for($user, "cartable")->create();

    expect($cart->cartable)->toBeInstanceOf(User::class);
});

test("guest_can_have_cart", function () {
    $guest = Guest::factory()->create();

    $cart = Cart::factory()->for($guest, "cartable")->create();

    expect($cart->cartable)->toBeInstanceOf(Guest::class);
});
