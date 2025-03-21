<?php

namespace Modules\Orders\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Orders\Models\Order;
use Modules\Payments\Models\PaymentMethod;

class PaymentAttemptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Orders\Models\PaymentAttempt::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "order_id" => fn() => Order::factory(),
            "payment_method" => fake()->randomElement(
                PaymentMethod::all()->pluck("code")
            ),
            "status" => OrderPaymentStatus::PENDING,
            "payment_details" => ["id" => fake()->slug(3)],
        ];
    }
}
