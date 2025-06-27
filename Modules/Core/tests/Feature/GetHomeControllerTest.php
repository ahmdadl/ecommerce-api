<?php

use Modules\Banners\Models\Banner;
use Modules\Orders\Models\OrderItem;
use Modules\Products\Models\Product;

it("gets_home_data", function () {
    asGuest()
        ->getJson(route("api.home"))
        ->assertStatus(200)
        ->assertJsonStructure(["data"])
        ->assertSee("banners")
        ->assertSee("bestSellers");
});

it("gets_updated_localized_banners", function () {
    Banner::factory()->count(2)->create();

    asGuest()
        ->getJson(route("api.home"))
        ->assertOk()
        ->assertJsonCount(2, "data.banners");

    $banner = Banner::factory()->create();

    app()->setLocale("ar");

    asGuest()
        ->getJson(route("api.home"))
        ->assertOk()
        ->assertJsonCount(3, "data.banners")
        ->assertSee($banner->title);
});

it("gets_updated_localized_best_sellers", function () {
    $products = Product::factory()->count(2)->create();

    $products->each(
        fn($product) => OrderItem::factory()->for($product)->count(2)->create()
    );

    asGuest()
        ->getJson(route("api.home"))
        ->assertOk()
        ->assertJsonCount(2, "data.bestSellers");

    $product = Product::factory()->create();

    app()->setLocale("ar");

    asGuest()
        ->getJson(route("api.home"))
        ->assertOk()
        ->assertJsonCount(3, "data.bestSellers")
        ->assertSee($product->title);
})->skip();
