<?php

namespace Modules\Addresses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
        return [
            "user_id" => fn() => User::factory(),
            "government_id" => fn() => \Modules\Governments\Models\Government::factory(),
            "city_id" => fn() => \Modules\Cities\Models\City::factory(),
            "firstName" => fake()->name,
            "lastName" => fake()->name,
            "title" => fake()->sentence(1),
            "address" => fake()->address,
            "phoneNumber" => fake()->phoneNumber,
        ];
    }
}
