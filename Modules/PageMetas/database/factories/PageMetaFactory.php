<?php

namespace Modules\PageMetas\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PageMetaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\PageMetas\Models\PageMeta::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

