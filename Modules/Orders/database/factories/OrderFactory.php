<?php

namespace Modules\Orders\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Carts\ValueObjects\CartTotals;
use Modules\Coupons\Models\Coupon;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Orders\Enums\OrderStatus;
use Modules\Orders\Models\OrderAddress;
use Modules\Orders\Models\OrderCoupon;
use Modules\Payments\Models\PaymentMethod;
use Modules\Users\Database\Factories\UserFactory;
use Modules\Users\Models\User;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Orders\Models\Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "user_id" => fn() => User::factory()->customer(),
            "coupon_id" => fn() => OrderCoupon::factory(),
            "address_id" => fn() => OrderAddress::factory(),
            "totals" => CartTotals::default(),
            "payment_method" => PaymentMethod::inRandomOrder()->first()->code,
            "status" => OrderStatus::PENDING,
            "payment_status" => OrderPaymentStatus::PENDING,
        ];
    }
}
