<?php

use Modules\Brands\Models\Brand;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

it("gets_all_active_brands", function () {
    Brand::factory()
        ->count(2)
        ->create([
            "is_active" => false,
        ]);
    Brand::factory()
        ->count(3)
        ->create([
            "is_active" => true,
        ]);

    expect(Brand::count())->toBe(5);

    asGuest();

    get(route("api.brands.index"))
        ->assertOk()
        ->assertJsonCount(3, "data.records");
});

it("gets_active_brand_with_products", function () {
    $activeBrand = Brand::factory()->create([
        "is_active" => true,
    ]);
    $inactiveBrand = Brand::factory()->create([
        "is_active" => false,
    ]);

    asGuest();

    getJson(route("api.brands.show", $activeBrand->slug))
        ->assertOk()
        ->assertJsonPath("data.brand.id", $activeBrand->id);

    getJson(route("api.brands.show", [$inactiveBrand->slug]))->assertNotFound();
});
