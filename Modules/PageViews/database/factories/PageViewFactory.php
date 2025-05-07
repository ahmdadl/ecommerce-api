<?php

namespace Modules\PageViews\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Guests\Models\Guest;
use Modules\PageViews\ValueObjects\UserAgent;
use Modules\Products\Models\Product;
use Modules\Tags\Models\Tag;
use Modules\Users\Models\User;

class PageViewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\PageViews\Models\PageView::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "viewable_id" => Str::ulid()->toBase32(),
            "viewable_type" => null, // overridden in states
            "viewerable_id" => Str::ulid()->toBase32(),
            "viewerable_type" => null, // overridden in states
            "agent" => UserAgent::fromUserAgent(fake()->userAgent()),
            "ip_address" => fake()->boolean() ? fake()->ipv4() : null,
            "page" => null,
        ];
    }

    public function product(): static
    {
        return $this->state(
            fn() => [
                "viewable_type" => Product::class,
                "viewable_id" => Product::factory(),
            ]
        );
    }

    public function category(): static
    {
        return $this->state(
            fn() => [
                "viewable_type" => Category::class,
                "viewable_id" => Category::factory(),
            ]
        );
    }

    public function brand(): static
    {
        return $this->state(
            fn() => [
                "viewable_type" => Brand::class,
                "viewable_id" => Brand::factory(),
            ]
        );
    }

    public function tag(): static
    {
        return $this->state(
            fn() => [
                "viewable_type" => Tag::class,
                "viewable_id" => Tag::factory(),
            ]
        );
    }

    // ===== Viewerable States =====

    public function user(): static
    {
        return $this->state(
            fn() => [
                "viewerable_type" => User::class,
                "viewerable_id" => User::factory(),
            ]
        );
    }

    public function guest(): static
    {
        return $this->state(
            fn() => [
                "viewerable_type" => Guest::class,
                "viewerable_id" => Guest::factory(),
            ]
        );
    }
}
