<?php

use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Addresses\Models\Address;
use Modules\Coupons\Models\Coupon;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;

use function Pest\Laravel\actingAs;

test("user_can_add_product_to_cart", function () {
    $product = Product::factory()->create(["salePrice" => 300]);
    /** @var Authenticatable $user */
    $user = User::factory()->create();

    $response = actingAs($user)->postJson(route("api.cart.add", [$product]));

    $response = $response->assertOk()->json()["data"];

    expect($response["cart"]["totals"]["total"])->toBe(300);
});

test("user_adding_twice_to_cart_will_update_quantity", function () {
    $product = Product::factory()->create(["salePrice" => 300]);
    /** @var Authenticatable $user */
    $user = User::factory()->create();

    $response = actingAs($user)->postJson(route("api.cart.add", [$product]));
    $response = actingAs($user)->postJson(route("api.cart.add", [$product]), [
        "quantity" => 2,
    ]);

    $response = $response->assertOk()->json()["data"];

    expect($response["cart"]["totals"]["total"])->toBe(600);
});

test("user_can_get_cart", function () {
    $product = Product::factory()->create(["salePrice" => 300]);
    /** @var Authenticatable $user */
    $user = User::factory()->create();

    actingAs($user)->postJson(route("api.cart.add", [$product]));

    $response = actingAs($user)
        ->getJson(route("api.cart.index"))
        ->assertOk()
        ->json()["data"];

    expect($response["cart"]["totals"]["total"])->toBe(300);
});

test("user_can_remove_product_from_cart", function () {
    $product = Product::factory()->create(["salePrice" => 300]);
    /** @var Authenticatable $user */
    $user = User::factory()->create();

    actingAs($user)->postJson(route("api.cart.add", [$product]));

    $response = actingAs($user)
        ->deleteJson(route("api.cart.remove-by-product", [$product]))
        ->assertOk()
        ->json()["data"];

    expect($response["cart"]["totals"]["total"])->toBe(0);
});

test("user_can_update_product_quantity_in_cart", function () {
    $product = Product::factory()->create(["salePrice" => 300]);
    /** @var Authenticatable $user */
    $user = User::factory()->create();

    actingAs($user)->postJson(route("api.cart.add", [$product]));

    $response = actingAs($user)
        ->patchJson(route("api.cart.update-by-product", [$product]), [
            "quantity" => 2,
        ])
        ->assertOk()
        ->json()["data"];

    expect($response["cart"]["totals"]["total"])->toBe(600);
});

test("cart_address_can_be_set_only", function () {
    $product = Product::factory()->create(["salePrice" => 300]);
    /** @var Authenticatable $user */
    $user = User::factory()->create();

    actingAs($user)->postJson(route("api.cart.add", [$product]));

    $address = Address::factory()->withShippingFee(150)->create();

    $response = actingAs($user)
        ->patchJson(route("api.cart.set-address", [$address]))
        ->assertOk()
        ->json();

    expect($response["data"]["cart"]["totals"]["total"])->toBe(450);
});

test("cart_coupon_can_be_set_and_removed", function () {
    $product = Product::factory()->create(["salePrice" => 300]);
    /** @var Authenticatable $user */
    $user = User::factory()->create();

    actingAs($user)->postJson(route("api.cart.add", [$product]));

    $coupon = Coupon::factory()->percentage(50)->create();

    $response = actingAs($user)
        ->patchJson(route("api.cart.apply-coupon", [$coupon->code]))
        ->assertOk()
        ->json();

    expect($response["data"]["cart"]["totals"]["total"])->toBe(150);

    $response = actingAs($user)
        ->deleteJson(route("api.cart.remove-coupon"))
        ->assertOk()
        ->json();

    expect($response["data"]["cart"]["totals"]["total"])->toBe(300);
});

test("cart_cannot_apply_invalid_coupon", function () {
    $product = Product::factory()->create(["salePrice" => 300]);
    /** @var Authenticatable $user */
    $user = User::factory()->create();
    actingAs($user)->postJson(route("api.cart.add", [$product]));

    $expiredCoupon = Coupon::factory()->expired()->create();
    $inactiveCoupon = Coupon::factory()->inactive()->create();
    $maxDiscountCoupon = Coupon::factory()
        ->fixed(270)
        ->create([
            "max_discount" => 50,
        ]);

    actingAs($user)
        ->patchJson(route("api.cart.apply-coupon", [$expiredCoupon]))
        ->assertStatus(400);

    actingAs($user)
        ->patchJson(route("api.cart.apply-coupon", [$inactiveCoupon]))
        ->assertStatus(400);

    actingAs($user)
        ->patchJson(route("api.cart.apply-coupon", [$maxDiscountCoupon]))
        ->assertStatus(400);
});

test("cart_automatically_selects_default_address", function () {
    $product = Product::factory()->create(["salePrice" => 300]);
    /** @var Authenticatable $user */
    $user = User::factory()->create();

    // Create a default address for the user
    $defaultAddress = Address::factory()
        ->withShippingFee(150)
        ->create([
            "user_id" => $user->id,
            "is_default" => true,
        ]);

    actingAs($user)
        ->getJson(route("api.cart.index"), [
            "params" => [
                "with" => ["addresses"],
            ],
        ])
        ->assertOk()
        ->assertSee($defaultAddress->id);
});

test("cart_automatically_selects_first_address_when_no_default", function () {
    $product = Product::factory()->create(["salePrice" => 300]);
    /** @var Authenticatable $user */
    $user = User::factory()->create();

    // Create a non-default address for the user
    $firstAddress = Address::factory()
        ->withShippingFee(150)
        ->create([
            "user_id" => $user->id,
            "is_default" => false,
        ]);

    actingAs($user)
        ->getJson(route("api.cart.index"))
        ->assertOk()
        ->assertSee($firstAddress->id);
});
