<?php

use Modules\Products\Models\Product;
use Modules\Categories\Models\Category;
use Modules\Brands\Models\Brand;
use Illuminate\Support\Str;
use Modules\Carts\Models\Cart;
use Modules\Carts\Models\CartItem;
use Modules\Users\Models\User;
use Modules\Wishlists\Services\WishlistService;

use function Pest\Laravel\actingAs;

it("can be created with factory", function () {
    $product = Product::factory()->create([
        "title" => ["en" => "Whey Protein"],
        "price" => 29.99,
        "salePrice" => 24.99,
    ]);

    expect($product)
        ->toBeInstanceOf(Product::class)
        ->id->toBeString() // ULID
        ->title->toBe("Whey Protein")
        ->price->toBe(29.99)
        ->salePrice->toBe(24.99);
});

it("generates a slug from title", function () {
    $product = Product::factory()->create([
        "title" => ["en" => "Pre-Workout Boost"],
    ]);

    expect($product->slug)->toBe("pre-workout-boost");
});

it("sets salePrice to price when not provided", function () {
    $product = Product::factory()->create([
        "title" => ["en" => "BCAA Powder"],
        "price" => 19.99,
        "salePrice" => null,
    ]);

    expect($product->salePrice)->toBe(19.99);
});

it("correctly determines if product has a discount", function () {
    $discounted = Product::factory()->create([
        "title" => ["en" => "Creatine"],
        "price" => 15.0,
        "salePrice" => 12.0,
    ]);

    $notDiscounted = Product::factory()->create([
        "title" => ["en" => "Protein Bar"],
        "price" => 10.0,
        "salePrice" => 10.0,
    ]);

    expect($discounted->isDiscounted)
        ->toBeTrue()
        ->and($notDiscounted->isDiscounted)
        ->toBeFalse();
});

it("calculates discounted price correctly", function () {
    $product = Product::factory()->create([
        "title" => ["en" => "Vegan Protein"],
        "price" => 39.99,
        "salePrice" => 29.99,
    ]);

    $noDiscount = Product::factory()->create([
        "title" => ["en" => "Energy Gel"],
        "price" => 5.0,
        "salePrice" => 5.0,
    ]);

    expect($product->discountedPrice)
        ->toBeFloat(10.0) // 39.99 - 29.99
        ->and($noDiscount->discountedPrice)
        ->toBeFloat(0.0);
});

it("scopes products with discounts", function () {
    Product::factory()->create([
        "title" => ["en" => "Whey Protein"],
        "price" => 30.0,
        "salePrice" => 25.0, // Has discount
    ]);

    Product::factory()->create([
        "title" => ["en" => "Multivitamin"],
        "price" => 20.0,
        "salePrice" => 20.0, // No discount
    ]);

    $discounted = Product::hasDiscount()->get();

    expect($discounted)
        ->toHaveCount(1)
        ->and($discounted->first()->title)
        ->toBe("Whey Protein");
});

it("has a category relationship", function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        "title" => ["en" => "Protein Shake"],
        "category_id" => $category->id,
    ]);

    expect($product->category)
        ->toBeInstanceOf(Category::class)
        ->id->toBe($category->id);
});

it("has a brand relationship", function () {
    $brand = Brand::factory()->create();
    $product = Product::factory()->create([
        "title" => ["en" => "Pre-Workout"],
        "brand_id" => $brand->id,
    ]);

    expect($product->brand)->toBeInstanceOf(Brand::class)->id->toBe($brand->id);
});

it("supports translations for title and description", function () {
    $product = Product::factory()->create([
        "title" => ["en" => "BCAA", "es" => "BCAA Español"],
        "description" => [
            "en" => "Branch Chain Amino Acids",
            "es" => "Aminoácidos de Cadena Ramificada",
        ],
    ]);

    expect($product->getTranslation("title", "en"))
        ->toBe("BCAA")
        ->and($product->getTranslation("title", "es"))
        ->toBe("BCAA Español")
        ->and($product->getTranslation("description", "en"))
        ->toBe("Branch Chain Amino Acids")
        ->and($product->getTranslation("description", "es"))
        ->toBe("Aminoácidos de Cadena Ramificada");
});

it("can be soft deleted", function () {
    $product = Product::factory()->create([
        "title" => ["en" => "Energy Drink"],
    ]);

    $product->delete();

    expect(Product::withTrashed()->find($product->id))
        ->not->toBeNull()
        ->deleted_at->not->toBeNull()
        ->and(Product::find($product->id))
        ->toBeNull();
});

it("calculates discounted percentage correctly", function () {
    $product = Product::factory()->create([
        "title" => ["en" => "Vegan Protein"],
        "price" => 39.99,
        "salePrice" => 29.99,
    ]);

    $noDiscount = Product::factory()->create([
        "title" => ["en" => "Energy Gel"],
        "price" => 5.0,
        "salePrice" => 5.0,
    ]);

    expect($product->discountedPercentage)
        ->toBeFloat(25.0) // 39.99 - 29.99
        ->and($noDiscount->discountedPercentage)
        ->toBeFloat(0.0);
});

it("checks if product is wished by current user", function () {
    $product = Product::factory()->create();

    actingAs(User::factory()->customer()->create());

    expect($product->isWished)->toBeFalse();

    wishlistService()->addItem($product);

    $product->refresh();
    expect($product->isWished)->toBeTrue();
});

it("calculates carted quantity for current user", function () {
    $product = Product::factory()->create();

    actingAs($user = User::factory()->customer()->create());
    $cart = Cart::factory()->for($user, "cartable")->create();
    CartItem::factory()->for($cart)->create(); // another product for current user
    CartItem::factory()->for($product)->create(); // same product for another user

    $product->refresh();
    expect($product->cartedQuantity)->toBe(0);

    CartItem::factory()
        ->for($product)
        ->for($cart)
        ->create([
            "quantity" => 2,
        ]); // same product for current user

    $product->refresh();
    expect($product->cartedQuantity)->toBe(2);
});
