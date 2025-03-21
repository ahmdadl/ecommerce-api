<?php

namespace Modules\Coupons\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Coupons\Enums\CouponDiscountType;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Coupons\Models\Coupon::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "code" => fake()->unique()->regexify("[A-Z0-9]{6,10}"),
            "name" => fake()->words(3, true),
            "starts_at" => fake()
                ->dateTimeBetween("-1 month", "now")
                ->format("Y-m-d"),
            "ends_at" => fake()
                ->dateTimeBetween("now", "+3 months")
                ->format("Y-m-d"),
            "discount_type" => CouponDiscountType::FIXED,
            "value" => 50,
            "max_discount" => fake()->optional(0.3)->randomFloat(2, 1000, 5000),
            "used_count" => fake()->numberBetween(0, 50),
            "is_active" => true,
        ];
    }

    /**
     * expired coupon
     */
    public function expired(): static
    {
        return $this->state(
            fn(array $attrs) => [
                "starts_at" => now()->format("Y-m-d"),
                "ends_at" => now()->subYear()->format("Y-m-d"),
            ]
        );
    }

    /**
     * in active coupon
     */
    public function inactive(): static
    {
        return $this->state(
            fn(array $attrs) => [
                "is_active" => false,
            ]
        );
    }

    /**
     * fixed discount
     */
    public function fixed(float|int $value): static
    {
        return $this->state(
            fn(array $attrs) => [
                "discount_type" => CouponDiscountType::FIXED,
                "value" => $value,
            ]
        );
    }

    /**
     * percentage discount
     */
    public function percentage(float|int $value): static
    {
        return $this->state(
            fn(array $attrs) => [
                "discount_type" => CouponDiscountType::PERCENTAGE,
                "value" => $value,
            ]
        );
    }
}
