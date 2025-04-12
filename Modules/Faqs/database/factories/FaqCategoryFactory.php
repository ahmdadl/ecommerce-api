<?php

namespace Modules\Faqs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FaqCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Faqs\Models\FaqCategory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "title" => [
                "en" => fake()->sentence,
                "ar" => fake()->sentence,
            ],
            "is_active" => true,
        ];
    }
}
