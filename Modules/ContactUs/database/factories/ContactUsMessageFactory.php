<?php

namespace Modules\ContactUs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactUsMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\ContactUs\Models\ContactUsMessage::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "name" => fake()->name(),
            "email" => fake()->unique()->email(),
            "phone" => fakePhone(),
            "order_id" => fake()->optional()->uuid(),
            "subject" => fake()->sentence(),
            "message" => fake()->paragraph(),
            "is_seen" => false,
            "replied_at" => null,
            "reply" => null,
        ];
    }
}
