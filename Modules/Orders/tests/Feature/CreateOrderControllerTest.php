<?php

use Modules\Addresses\Models\Address;
use Modules\Carts\Models\Cart;
use Modules\Carts\Models\CartItem;
use Modules\Carts\Services\CartService;
use Modules\Coupons\Models\Coupon;
use Modules\Orders\Models\Order;
use Modules\Orders\Models\OrderItem;
use Modules\Payments\Models\PaymentMethod;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;

use function Pest\Laravel\actingAs;

it("cannot_create_order_with_invalid_data", function () {
    $user = User::factory()->customer()->create();
    $address = Address::factory()->for($user)->create();
    $cart = Cart::factory()->create();
    $cart->cartable()->associate($user)->save();

    $paymentMethod = PaymentMethod::active()->inRandomOrder()->first();

    $postOrder = fn(array $data = []) => actingAs($user)->postJson(
        route("api.orders.store"),
        $data
    );

    // check if payment method is required
    $postOrder()->assertJsonValidationErrorFor("payment_method");

    // check if cart is required
    $postOrder([
        "payment_method" => $paymentMethod->code,
    ])
        ->assertStatus(400)
        ->assertSee("Cart");

    CartItem::factory()->for($cart)->create();

    // check if address is required
    $postOrder([
        "payment_method" => $paymentMethod->code,
    ])
        ->assertStatus(400)
        ->assertSee("Address");

    $cart->address()->associate($address)->save();

    // check if coupon is validated
    $cart
        ->coupon()
        ->associate(Coupon::factory()->expired()->create())
        ->save();
    $postOrder([
        "payment_method" => $paymentMethod->code,
    ])
        ->assertStatus(400)
        ->assertSee("Coupon");
});

it("can_create_an_order", function () {
    $user = User::factory()->customer()->create();
    $address = Address::factory()->create();
    $coupon = Coupon::factory()->percentage(50)->create();
    $cart = Cart::factory()
        ->for($user, "cartable")
        ->for($address)
        ->for($coupon)
        ->create();
    CartItem::factory()->for($cart)->count(2)->create();
    $paymentMethod = PaymentMethod::active()->inRandomOrder()->first();

    $cartService = new CartService($cart);
    $cartService->refresh();

    expect($cart->totals->coupon)->toBe(
        (float) round($cart->totals->subtotal / 2, 2)
    );

    $response = actingAs($user)
        ->postJson(route("api.orders.store"), [
            "payment_method" => $paymentMethod->code,
        ])
        ->assertOk()
        ->json();

    $order = Order::firstWhere("id", $response["data"]["record"]["id"]);

    expect($order->totals->coupon)->toBe(
        (float) round($order->totals->subtotal / 2, 2)
    );
    expect(OrderItem::count())->toBe(2);
});
