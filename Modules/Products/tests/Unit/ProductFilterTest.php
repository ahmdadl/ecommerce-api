<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Products\Filters\ProductFilter;
use Modules\Products\Models\Product;
use Modules\Tags\Models\Tag;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create a fresh Request instance for each test
    $this->request = new Request();
});

// Test category_id filter with related category
it("filters products by specific category_id", function () {
    $category1 = Category::factory()->create();
    $category2 = Category::factory()->create();
    Product::factory()->create([
        "category_id" => $category1->id,
        "price" => 25.0,
    ]);
    Product::factory()->create([
        "category_id" => $category2->id,
        "price" => 30.0,
    ]);

    $this->request->replace(["category" => $category1->id]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)
        ->toHaveCount(1)
        ->and($products->first()->category_id)
        ->toBe($category1->id);
});

// Test brand_id filter with related brand
it("filters products by specific brand_id", function () {
    $brand1 = Brand::factory()->create();
    $brand2 = Brand::factory()->create();
    Product::factory()->create(["brand_id" => $brand1->id, "price" => 15.0]);
    Product::factory()->create(["brand_id" => $brand2->id, "price" => 20.0]);

    $this->request->replace(["brand" => $brand1->id]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)
        ->toHaveCount(1)
        ->and($products->first()->brand_id)
        ->toBe($brand1->id);
});

// Test title filter with partial match
it("filters products by partial title match", function () {
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "title" => json_encode(["en" => "Blue Shirt"]),
    ]);
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "title" => json_encode(["en" => "Red Pants"]),
    ]);

    $this->request->replace(["title" => "shirt"]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)
        ->toHaveCount(1)
        ->and(json_decode($products->first()->title, true)["en"])
        ->toBe("Blue Shirt");
});

// Test min_price filter with boundary conditions
it(
    "filters products with price greater than or equal to min_price",
    function () {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        Product::factory()->create([
            "category_id" => $category->id,
            "brand_id" => $brand->id,
            "price" => 10.0,
        ]);
        Product::factory()->create([
            "category_id" => $category->id,
            "brand_id" => $brand->id,
            "price" => 25.0,
        ]);
        Product::factory()->create([
            "category_id" => $category->id,
            "brand_id" => $brand->id,
            "price" => 30.0,
        ]);

        $this->request->replace(["min_price" => 25.0]);
        $filter = new ProductFilter($this->request);

        $products = Product::filter($filter)->get();

        expect($products)
            ->toHaveCount(2)
            ->and($products->pluck("price")->all())
            ->each->toBeGreaterThanOrEqual(25.0);
    }
);

// Test min_price with 0 edge case
it(
    "filters products with min_price of 0 including zero-priced items",
    function () {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        Product::factory()->create([
            "category_id" => $category->id,
            "brand_id" => $brand->id,
            "price" => 0.0,
        ]);
        Product::factory()->create([
            "category_id" => $category->id,
            "brand_id" => $brand->id,
            "price" => 15.0,
        ]);
        Product::factory()->create([
            "category_id" => $category->id,
            "brand_id" => $brand->id,
            "price" => 50.0,
        ]);

        $this->request->replace(["min_price" => 0]);
        $filter = new ProductFilter($this->request);

        $products = Product::filter($filter)->get();

        expect($products)
            ->toHaveCount(3)
            ->and($products->pluck("price")->all())
            ->each->toBeGreaterThanOrEqual(0.0);
    }
);

// Test max_price filter with boundary conditions
it("filters products with price less than or equal to max_price", function () {
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "price" => 10.0,
    ]);
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "price" => 25.0,
    ]);
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "price" => 30.0,
    ]);

    $this->request->replace(["max_price" => 25.0]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)
        ->toHaveCount(2)
        ->and($products->pluck("price")->all())
        ->each->toBeLessThanOrEqual(25.0);
});

// Test in_stock filter for true
it("filters products that are in stock", function () {
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "stock" => 5,
    ]);
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "stock" => 0,
    ]);
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "stock" => 10,
    ]);

    $this->request->replace(["in_stock" => "1"]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)
        ->toHaveCount(2)
        ->and($products->pluck("stock")->all())
        ->each->toBeGreaterThan(0);
});

// Test in_stock filter for false
it("filters products that are out of stock", function () {
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "stock" => 5,
    ]);
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "stock" => 0,
    ]);

    $this->request->replace(["in_stock" => "false"]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)
        ->toHaveCount(1)
        ->and($products->first()->stock)
        ->toBe(0);
});

// Test is_main filter for true
it("filters products where is_main is true", function () {
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "is_main" => true,
    ]);
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "is_main" => false,
    ]);

    $this->request->replace(["is_main" => "true"]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)
        ->toHaveCount(1)
        ->and($products->first()->is_main)
        ->toBeTrue();
});

// Test sku filter with exact match
it("filters products by exact sku", function () {
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "sku" => "ABC123",
    ]);
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "sku" => "XYZ789",
    ]);

    $this->request->replace(["sku" => "ABC123"]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)
        ->toHaveCount(1)
        ->and($products->first()->sku)
        ->toBe("ABC123");
});

// Test combination of filters
it("filters products with multiple conditions", function () {
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "price" => 30.0,
        "stock" => 5,
    ]);
    Product::factory()->create([
        "category_id" => $category->id,
        "brand_id" => $brand->id,
        "price" => 10.0,
        "stock" => 0,
    ]);

    $this->request->replace(["min_price" => 20.0, "in_stock" => "true"]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)
        ->toHaveCount(1)
        ->and($products->first()->price)
        ->toBe(30.0)
        ->and($products->first()->stock)
        ->toBe(5);
});

// Test ignoring invalid filters
it("ignores invalid filter parameters", function () {
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    Product::factory()
        ->count(2)
        ->create(["category_id" => $category->id, "brand_id" => $brand->id]);

    $this->request->replace(["invalid_filter" => "value"]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)->toHaveCount(2); // No filtering applied
});

it("filters products by specific tag_id", function () {
    $tag1 = Tag::factory()->create();
    $tag2 = Tag::factory()->create();
    $product1 = Product::factory()->create();
    $product2 = Product::factory()->create();
    $product1->tags()->attach($tag1);
    $product2->tags()->attach($tag2);

    $this->request->replace(["tag" => $tag1->id]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)
        ->toHaveCount(1)
        ->and($products->first()->id)
        ->toBe($product1->id);
});

it("filters products by specific tag slug", function () {
    $tag1 = Tag::factory()->create();
    $tag2 = Tag::factory()->create();
    $product1 = Product::factory()->create();
    $product2 = Product::factory()->create();
    $product1->tags()->attach($tag1);
    $product2->tags()->attach($tag2);

    $this->request->replace(["tagSlug" => $tag1->slug]);
    $filter = new ProductFilter($this->request);

    $products = Product::filter($filter)->get();

    expect($products)
        ->toHaveCount(1)
        ->and($products->first()->id)
        ->toBe($product1->id);
});
