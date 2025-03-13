<?php

namespace Modules\Banners\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Banners\Enums\BannerActionType;

class BannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Banners\Models\Banner::class;

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
            "subtitle" => [
                "en" => fake()->sentence,
                "ar" => fake()->sentence,
            ],
            "media" => str(fake()->sentence)->slug("_")->toString() . ".png",
            "action" => BannerActionType::MEDIA,
        ];
    }
}
