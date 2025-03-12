<?php

use Illuminate\Support\Carbon;
use Modules\Coupons\Actions\CalculateCouponDiscountAction;
use Modules\Coupons\Actions\ValidateCouponAction;
use Modules\Coupons\Actions\CalculateCoupondiscountedPriceAction;
use Modules\Coupons\Enums\CouponDiscountType;
use Modules\Coupons\Models\Coupon;

beforeEach(function () {
    $this->calculator = new CalculateCouponDiscountAction();
    $this->validator = new ValidateCouponAction();
});

test("coupon_have_casts", function () {
    $coupon = Coupon::factory()->create([
        "max_discount" => 22.0,
    ]);

    expect($coupon->value)
        ->toBeFloat()
        ->and($coupon->starts_at)
        ->toBeInstanceOf(Carbon::class)
        ->and($coupon->ends_at)
        ->toBeInstanceOf(Carbon::class)
        ->and($coupon->discount_type)
        ->toBeInstanceOf(CouponDiscountType::class)
        ->and($coupon->max_discount)
        ->toBeFloat()
        ->and($coupon->used_count)
        ->toBeInt();
});

it("validates a valid coupon by code", function () {
    $coupon = Coupon::factory()->create([
        "code" => "SAVE20",
        "is_active" => true,
        "starts_at" => now()->subDay(),
        "ends_at" => now()->addDay(),
        "discount_type" => CouponDiscountType::PERCENTAGE->value,
        "value" => 20,
        "max_discount" => null,
    ]);

    expect(fn() => $this->validator->handle("SAVE20", 100.0))->not->toThrow(
        Exception::class
    );
});

it("calculates discounted price for percentage discount", function () {
    $coupon = Coupon::factory()->create([
        "discount_type" => CouponDiscountType::PERCENTAGE->value,
        "value" => 20.0,
    ]);

    $discountedPrice = $this->calculator->handle($coupon, 100.0);
    expect($discountedPrice)->toBe(20.0);
});

it("rounds discounted price to 2 decimal places", function () {
    $coupon = Coupon::factory()->create([
        "discount_type" => CouponDiscountType::PERCENTAGE->value,
        "value" => 33.333,
    ]);

    $discountedPrice = $this->calculator->handle($coupon, 100.0);
    expect($discountedPrice)->toBe(33.33);
});

it("validates if discounted price larger than max discount", function () {
    $coupon = Coupon::factory()->create([
        "discount_type" => CouponDiscountType::FIXED->value,
        "value" => 150.0,
        "max_discount" => 100.0,
    ]);

    $discountedPrice = $this->calculator->handle($coupon, 100.0);
    expect($discountedPrice)->toBe(150.0);

    expect(fn() => $this->validator->handle($coupon, 100.0))->toThrow(
        \Exception::class
    );
});

it("throws InvalidArgumentException for negative total price", function () {
    $coupon = Coupon::factory()->create([
        "discount_type" => CouponDiscountType::FIXED->value,
        "value" => 10.0,
    ]);

    expect(fn() => $this->validator->handle($coupon, -50.0))->toThrow(
        \Exception::class,
        __("coupons::t.invalid_total_price")
    );
});
