<?php

namespace Modules\Guests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Guests\Models\Guest;

/**
 * @extends Factory<Guest>
 * @mixin Factory<Guest>
 */
class GuestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Guests\Models\Guest::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'totals' => [],
        ];
    }
}
