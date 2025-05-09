<?php

use Modules\Addresses\Models\Address;
use Modules\Carts\Actions\ApplyWalletAmountForCartAction;
use Modules\Carts\Models\Cart;
use Modules\Carts\Models\CartItem;
use Modules\Carts\Services\CartService;
use Modules\Cities\Models\City;
use Modules\Coupons\Enums\CouponDiscountType;
use Modules\Coupons\Models\Coupon;
use Modules\Governments\Models\Government;
use Modules\Products\Models\Product;
use Modules\Users\Enums\UserTotalsKey;
use Modules\Users\Models\User;
use Modules\Users\ValueObjects\UserTotals;

test("cart_totals_updated_after_adding_item", function () {
    $cart = Cart::factory()->create();

    $cartService = new CartService($cart);

    $productA = Product::factory()->create([
        "price" => 100,
        "sale_price" => 50,
    ]);

    $productB = Product::factory()->create([
        "price" => 200,
        "sale_price" => 100,
    ]);

    $cartService->addItem($productA, 2);
    $cartService->addItem($productB);

    expect($cart->totals->original)->toBe((float) 400);
    expect($cart->totals->discount)->toBe((float) 200);
    expect($cart->totals->products)->toBe((int) 2);
    expect($cart->totals->items)->toBe((int) 3);
    expect($cart->totals->subtotal)->toBe((float) 400);
    expect($cart->totals->coupon)->toBe((float) 0);
    expect($cart->totals->shipping)->toBe((float) 0);
    expect($cart->totals->total)->toBe((float) 200);
});

it("cart_totals_updated_after_adding_items_to_old_cart", function () {
    $cart = Cart::factory()->create();

    $cartItems = CartItem::factory()->for($cart)->count(2)->create();

    $cartService = new CartService($cart);
    $cartService->refresh();

    expect($cart->totals->products)->toBe(2);
    $this->assertGreaterThanOrEqual(2, $cart->totals->items);

    $productA = Product::factory()->create([
        "price" => 100,
        "sale_price" => 50,
    ]);

    $cartService->addItem($productA);

    expect($cart->totals->products)->toBe(3);
    $this->assertGreaterThanOrEqual(3, $cart->totals->items);
});

test("cart_totals_calculate_after_coupon_applied", function () {
    $cart = Cart::factory()->create();

    $cartService = new CartService($cart);

    $productA = Product::factory()->create([
        "price" => 100,
        "sale_price" => 50,
    ]);

    $cartService->addItem($productA);

    expect($cart->totals->total)->toBe((float) 50);

    $fixedCoupon = Coupon::factory()->fixed(25)->create();

    $cartService->applyCoupon($fixedCoupon);

    expect($cart->totals->total)->toBe((float) 25);

    $cartService->removeCoupon();

    expect($cart->totals->total)->toBe((float) 50);

    $percentageCoupon = Coupon::factory()->percentage(50)->create();

    $cartService->applyCoupon($percentageCoupon);

    expect($cart->totals->total)->toBe((float) 25);
});

test("cart_totals_calculate_after_coupon_removed", function () {
    $cart = Cart::factory()->create();

    $cartService = new CartService($cart);

    $productA = Product::factory()->create([
        "price" => 100,
        "sale_price" => 50,
    ]);

    $cartService->addItem($productA);

    expect($cart->totals->total)->toBe((float) 50);

    $coupon = Coupon::factory()->fixed(25)->create();

    $cartService->applyCoupon($coupon);

    expect($cart->totals->total)->toBe((float) 25);

    $cartService->removeCoupon();

    expect($cart->totals->total)->toBe((float) 50);
});

test("calculate_shipping_fees_after_address", function () {
    $cart = Cart::factory()->create();
    $cartService = new CartService($cart);

    $cartService->addItem(
        Product::factory()->create([
            "sale_price" => 50,
        ])
    );

    $government = Government::factory()->create([
        "shipping_fees" => 200,
    ]);
    $city = City::factory()->for($government)->create();
    $address = Address::factory()->for($city)->for($government)->create();

    $cartService->setShippingAddress($address);

    expect($cart->totals->total)->toBe((float) 250);
});

it("updates_user_total_cart_items", function () {
    $user = User::factory()->customer()->create();
    $cart = Cart::factory()->for($user, "cartable")->create();
    $cartService = new CartService($cart);

    $cartService->addItem($productA = Product::factory()->create());
    $cartService->addItem($productB = Product::factory()->create());

    $validateCount = function (int $count) use ($user, $cartService) {
        $user->refresh();
        expect($user->totals->cartItems)->toBe($count);
        expect($cartService->cart->totals->items)->toBe($count);
    };

    $validateCount(2);

    $cartService->removeItem($cartService->findCartItemByProduct($productA));

    $validateCount(1);

    $cartService->destroy();

    $validateCount(0);
});

test("wallet_amount_can_be_used_on_cart", function () {
    $user = User::factory()->customer()->create();
    $cart = Cart::factory()->for($user, "cartable")->create();
    $cartService = new CartService($cart);
    $cartService->addItem(
        $productA = Product::factory()->create([
            "sale_price" => 100,
        ])
    );
    $cartService->addItem(
        $productB = Product::factory()->create([
            "sale_price" => 200,
        ])
    );

    auth()->setUser($user);

    expect($cart->totals->total)->toBe((float) 300);

    walletService()->fullyCredit(101, $user);

    ApplyWalletAmountForCartAction::new()->handle(100);

    $cart->refresh();

    expect($cart->totals->total)->toBe((float) 200);
});
