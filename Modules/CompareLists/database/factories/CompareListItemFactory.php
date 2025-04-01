<?php

namespace Modules\CompareLists\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CompareLists\Models\CompareList;

class CompareListItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\CompareLists\Models\CompareListItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "compare_list_id" => fn() => CompareList::factory(),
            "product_id" => fn() => \Modules\Products\Models\Product::factory(),
        ];
    }
}
