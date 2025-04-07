<?php

namespace Modules\Addresses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Governments\Models\Government;
use Modules\Users\Models\User;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Addresses\Models\Address::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $government = Government::factory()->create();

        return [
            "user_id" => fn() => User::factory(),
            "government_id" => $government,
            "city_id" => fn() => \Modules\Cities\Models\City::factory()->for(
                $government
            ),
            "first_name" => fake()->name,
            "last_name" => fake()->name,
            "title" => fake()->sentence(1),
            "address" => fake()->address,
            "phone" => "201034" . random_int(100000, 999999),
            "is_default" => false,
        ];
    }

    /**
     * Set the shipping fee for the associated Government.
     *
     * @param float $fee
     * @return $this
     */
    public function withShippingFee(float $fee)
    {
        return $this->state(function (array $attributes) use ($fee) {
            $government = Government::factory()->create([
                "shipping_fees" => $fee,
            ]);
            return [
                "government_id" => $government->id,
                "city_id" => fn() => \Modules\Cities\Models\City::factory()->for(
                    $government
                ),
            ];
        });
    }
}
