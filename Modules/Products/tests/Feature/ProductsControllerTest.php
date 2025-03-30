<?php

use Modules\Products\Models\Product;

use function Pest\Laravel\getJson;

it("gets_all_active_products", function () {
    $activeProducts = Product::factory(7)->create([
        "is_active" => true,
    ]);
    Product::factory(2)->create([
        "is_active" => false,
    ]);

    expect(Product::count())->toBe(9);

    asGuest();

    getJson(route("api.products.index"))
        ->assertOk()
        ->assertJsonCount(7, "data.records");

    getJson(route("api.products.index") . "?withCategory=1&withBrand=1")
        ->assertJsonPath(
            "data.records.0.category.id",
            $activeProducts->first()->category_id
        )
        ->assertJsonPath(
            "data.records.0.brand.id",
            $activeProducts->first()->brand_id
        );
});

it("gets_active_product", function () {
    $product = Product::factory()->create([
        "is_active" => true,
    ]);

    asGuest();

    getJson(route("api.products.show", $product->slug))
        ->assertOk()
        ->assertJsonPath("data.record.id", $product->id);

    getJson(route("api.products.show", $product->slug) . "?withCategory=1")
        ->assertOk()
        ->assertJsonPath("data.record.category.id", $product->category_id);
});
