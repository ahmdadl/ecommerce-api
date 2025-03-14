<?php

namespace Modules\Addresses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            "firstName" => fake()->name,
            "lastName" => fake()->name,
            "title" => fake()->sentence(1),
            "address" => fake()->address,
            "phoneNumber" => fake()->phoneNumber,
        ];
    }
}
