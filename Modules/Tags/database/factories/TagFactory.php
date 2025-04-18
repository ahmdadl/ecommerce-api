<?php

namespace Modules\Tags\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Tags\Models\Tag::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "title" => [
                "en" => $this->faker->words(3, true),
                "ar" => $this->faker->words(3, true),
            ],
            "is_active" => true,
        ];
    }
}
