<?php

use Modules\Orders\Models\Order;
use Modules\Orders\Models\OrderAddress;
use Modules\Orders\Models\OrderCoupon;
use Modules\Orders\Models\PaymentAttempt;
use Modules\Payments\Models\PaymentMethod;
use Modules\Users\Models\User;

test("order_has_relations", function () {
    $order = Order::factory()->create();
    $paymentAttempts = PaymentAttempt::factory()
        ->count(2)
        ->for($order)
        ->create();

    expect($order->user)
        ->toBeInstanceOf(User::class)
        ->and($order->shippingAddress)
        ->toBeInstanceOf(OrderAddress::class)
        ->and($order->coupon)
        ->toBeInstanceOf(OrderCoupon::class)
        ->and($order->paymentMethodRecord)
        ->toBeInstanceOf(PaymentMethod::class)
        ->and($order->paymentMethodRecord->name)
        ->toBeString(
            PaymentMethod::firstWhere("code", $order->payment_method)->name
        )
        ->and($order->paymentAttempts->count())
        ->toBeInt(2);
});
