<?php

use Illuminate\Http\UploadedFile;
use Modules\Addresses\Models\Address;
use Modules\Carts\Models\Cart;
use Modules\Carts\Models\CartItem;
use Modules\Carts\Services\CartService;
use Modules\Coupons\Models\Coupon;
use Modules\Orders\Models\Order;
use Modules\Orders\Models\OrderItem;
use Modules\Payments\Models\PaymentMethod;
use Modules\Products\Models\Product;
use Modules\Uploads\Actions\StoreUploadAction;
use Modules\Users\Models\User;

use function Pest\Laravel\actingAs;

it("cannot_create_order_with_invalid_data", function () {
    $user = User::factory()->customer()->create();
    $address = Address::factory()->for($user)->create();
    $cart = Cart::factory()->create();
    $cart->cartable()->associate($user)->save();

    $paymentMethod = PaymentMethod::code(
        PaymentMethod::CASH_ON_DELIVERY
    )->first();

    $postOrder = fn(array $data = []) => actingAs($user)->postJson(
        route("api.orders.store"),
        $data
    );

    // check if payment method is required
    $postOrder()->assertJsonValidationErrorFor("payment_method");

    // check if payment method is active
    PaymentMethod::where("code", PaymentMethod::FAWRY)->update([
        "is_active" => false,
    ]);
    $postOrder([
        "payment_method" => PaymentMethod::FAWRY,
    ])->assertJsonValidationErrorFor("payment_method");

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

it("can_create_an_order_with_cod", function () {
    $user = User::factory()->customer()->create();
    $address = Address::factory()->create();
    $coupon = Coupon::factory()->percentage(50)->create();
    $cart = Cart::factory()
        ->for($user, "cartable")
        ->for($address)
        ->for($coupon)
        ->create();
    CartItem::factory()->for($cart)->count(2)->create();
    $paymentMethod = PaymentMethod::CASH_ON_DELIVERY;

    $cartService = new CartService($cart);
    $cartService->refresh();

    expect($cart->totals->coupon)->toBe(
        (float) round($cart->totals->subtotal / 2, 2)
    );

    $response = actingAs($user)
        ->postJson(route("api.orders.store"), [
            "payment_method" => $paymentMethod,
        ])
        ->assertOk()
        ->json();

    $order = Order::firstWhere("id", $response["data"]["record"]["id"]);

    expect($order->totals->coupon)->toBe(
        (float) round($order->totals->subtotal / 2, 2)
    );
    expect(OrderItem::count())->toBe(2);
});

it("can_create_an_order_with_instapay", function () {
    $user = User::factory()->customer()->create();
    $address = Address::factory()->create();
    $coupon = Coupon::factory()->percentage(50)->create();
    $cart = Cart::factory()
        ->for($user, "cartable")
        ->for($address)
        ->for($coupon)
        ->create();
    CartItem::factory()->for($cart)->count(2)->create();
    $paymentMethod = PaymentMethod::INSTAPAY;

    $cartService = new CartService($cart);
    $cartService->refresh();

    expect($cart->totals->coupon)->toBe(
        (float) round($cart->totals->subtotal / 2, 2)
    );

    actingAs($user)
        ->postJson(route("api.orders.store"), [
            "payment_method" => $paymentMethod,
        ])
        ->assertJsonValidationErrorFor("receipt");

    $file = UploadedFile::fake()->create("test_receipt.png", 350, "image/png");
    $receipt = StoreUploadAction::new()->handle($file);

    $response = actingAs($user)
        ->postJson(route("api.orders.store"), [
            "payment_method" => $paymentMethod,
            "receipt" => $receipt->id,
        ])
        ->assertOk()
        ->json();

    $order = Order::firstWhere("id", $response["data"]["record"]["id"]);

    expect($order->totals->coupon)->toBe(
        (float) round($order->totals->subtotal / 2, 2)
    );
    expect(OrderItem::count())->toBe(2);
});
