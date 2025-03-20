<?php

namespace Modules\Orders\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Coupons\Models\Coupon;

class OrderCouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Orders\Models\OrderCoupon::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $coupon = Coupon::factory()->create();

        return [
            "coupon_id" => $coupon->id,
            "code" => $coupon->code,
            "name" => $coupon->name,
            "discount_type" => $coupon->discount_type,
            "value" => $coupon->value,
        ];
    }
}
