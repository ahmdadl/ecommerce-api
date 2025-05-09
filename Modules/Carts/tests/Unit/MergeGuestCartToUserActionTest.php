<?php

use Modules\Carts\Actions\MergeGuestCartToUserAction;
use Modules\Carts\Models\Cart;
use Modules\Carts\Models\CartItem;
use Modules\Carts\Services\CartService;
use Modules\Guests\Models\Guest;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\withoutExceptionHandling;

it("merges_cart_if_user_does_not_have_cart", function () {
    $guest = Guest::factory()->create();
    Cart::factory()->for($guest, "cartable")->create();
    $user = User::factory()->create();

    asGuest($guest);
    (new CartService($guest->cart))->addItem(
        $product = Product::factory()->create([
            "sale_price" => 100,
        ])
    );

    $guest->refresh();
    expect($guest->cart->totals->total)->toBe((float) 100);

    assertDatabaseMissing("carts", [
        "cartable_id" => $user->id,
        "cartable_type" => User::class,
    ]);

    MergeGuestCartToUserAction::new()->handle($guest, $user);

    assertDatabaseMissing("carts", [
        "cartable_id" => $guest->id,
        "cartable_type" => Guest::class,
    ]);

    assertDatabaseHas("carts", [
        "cartable_id" => $user->id,
        "cartable_type" => User::class,
    ]);

    $user->refresh();
    expect($user->cart->totals->total)->toBe((float) 100);
});

it("merges_cart_if_user_has_cart", function () {
    $guest = Guest::factory()->create();
    Cart::factory()->for($guest, "cartable")->create();
    $guestCartService = new CartService($guest->cart);
    $guestCartService->addItem(
        $productA = Product::factory()->create([
            "sale_price" => 100,
            "stock" => 150,
        ])
    );
    $guestCartService->addItem(
        $productB = Product::factory()->create([
            "sale_price" => 200,
        ])
    );

    $guest->refresh();
    expect($guest->cart->totals->total)->toBe((float) 300);

    $user = User::factory()->create();
    Cart::factory()->for($user, "cartable")->create();
    $userCartService = new CartService($user->cart);
    $userCartService->addItem(
        $productC = Product::factory()->create([
            "sale_price" => 300,
        ])
    );
    $userCartService->addItem($productA);

    $user->refresh();
    expect($user->cart->totals->total)->toBe((float) 400);

    MergeGuestCartToUserAction::new()->handle($guest, $user);

    $user->refresh();
    expect($user->cart->totals->total)->toBe((float) 700);
});

it("merges_cart_and_bypass_products_that_have_errors", function () {
    $guest = Guest::factory()->create();
    Cart::factory()->for($guest, "cartable")->create();
    $guestCartService = new CartService($guest->cart);
    $guestCartService->addItem(
        $productA = Product::factory()->create([
            "sale_price" => 100,
            "stock" => 2,
        ]),
        2
    );
    $guestCartService->addItem(
        $productB = Product::factory()->create([
            "sale_price" => 200,
        ])
    );

    $guest->refresh();
    expect($guest->cart->totals->total)->toBe((float) 400);

    $user = User::factory()->create();
    Cart::factory()->for($user, "cartable")->create();
    $userCartService = new CartService($user->cart);
    $userCartService->addItem(
        $productC = Product::factory()->create([
            "sale_price" => 300,
        ])
    );
    // this one is already in guest cart but it uses full stock
    // so the guest cart item will be ignored
    $userCartService->addItem($productA);

    $user->refresh();
    expect($user->cart->totals->total)->toBe((float) 400);

    MergeGuestCartToUserAction::new()->handle($guest, $user);

    $user->refresh();
    // $productA with 2 quantity from guest is ignored
    // so we only have it with quantity 1
    expect($user->cart->totals->total)->toBe((float) 600);
});
