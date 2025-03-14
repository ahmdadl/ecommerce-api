<?php

namespace Modules\Governments\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GovernmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Governments\Models\Government::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "title" => [
                "en" => fake()->city,
                "ar" => fake("ar")->city,
            ],
            "shippingFees" => fake()->randomFloat(2, 0, 100),
        ];
    }
}
