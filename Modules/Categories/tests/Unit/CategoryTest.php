<?php

use Modules\Categories\Models\Category;
use Modules\Products\Models\Product;

test("category_have_translated_attrs", function () {
    $category = Category::factory()->create([
        "title" => [
            "en" => "English Title",
            "ar" => "Arabic Title",
        ],
        "description" => [
            "en" => "English Description",
            "ar" => "Arabic Description",
        ],
    ]);

    app()->setLocale("en");
    expect($category->title)->toBe("English Title");
    expect($category->description)->toBe("English Description");
    app()->setLocale("ar");
    expect($category->title)->toBe("Arabic Title");
    expect($category->description)->toBe("Arabic Description");
});

test("category_have_slug", function () {
    $category = Category::factory()->create([
        "title" => [
            "en" => "English Title",
            "ar" => "Arabic Title",
        ],
    ]);

    expect($category->slug)->toBe("english-title");
});

test('category_have_products', function () {
    $category = Category::factory()->create();

    $products = Product::factory()->for($category)->count(5)->create();

    expect($category->products->count())->toBe(5);
});
