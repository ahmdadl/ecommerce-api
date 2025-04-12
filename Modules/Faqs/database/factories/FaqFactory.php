<?php

namespace Modules\Faqs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Faqs\Models\Faq::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "faq_category_id" => fn() => \Modules\Faqs\Models\FaqCategory::factory(),
            "question" => [
                "en" => fake()->sentence,
                "ar" => fake()->sentence,
            ],
            "answer" => [
                "en" => fake()->sentence,
                "ar" => fake()->sentence,
            ],
            "is_active" => true,
        ];
    }
}
