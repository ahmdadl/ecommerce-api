<?php

use Modules\Categories\Models\Category;
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

    getJson(route("api.products.index") . "?withCategory=1")
        ->assertJsonPath(
            "data.records.0.category.id",
            $activeProducts->last()->category_id
        )
        ->assertJsonPath(
            "data.records.0.brand.id",
            $activeProducts->last()->brand_id
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

it("gets_filtered_products", function () {
    $category = Category::factory()->create();
    $products = Product::factory(3)
        ->for($category)
        ->create([
            "is_active" => true,
            "stock" => 0,
        ]);

    asGuest();

    getJson(route("api.products.index") . "?in_stock=1")->assertJsonCount(
        0,
        "data.records"
    );

    getJson(
        route("api.products.index") . "?category=" . $category->id
    )->assertJsonCount(3, "data.records");

    getJson(route("api.products.index") . "?min_price=" . 5)->assertJsonCount(
        3,
        "data.records"
    );
});

test("filters_related_to_current_data", function () {
    $categoryA = Category::factory()->create();
    $categoryB = Category::factory()->create();

    Product::factory()->for($categoryA)->count(3)->create();
    Product::factory()->for($categoryB)->count(5)->create();

    expect(Product::active()->count())->toBe(8);

    asGuest();

    getJson(route("api.products.index"))
        ->assertJsonCount(8, "data.records")
        ->assertSee($categoryA->name)
        ->assertSee($categoryB->name);

    getJson(route("api.products.index") . "?category=" . $categoryB->id)
        ->assertJsonCount(5, "data.records")
        ->assertSee($categoryB->name)
        ->assertDontSee($categoryA->name);
});
