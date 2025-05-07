<?php

use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Core\Exceptions\ApiException;
use Modules\Guests\Models\Guest;
use Modules\PageViews\Actions\CreatePageViewAction;
use Modules\PageViews\Enums\ViewableType;
use Modules\PageViews\Models\PageView;
use Modules\Products\Models\Product;
use Modules\Tags\Models\Tag;
use Modules\Users\Models\User;

use function Pest\Laravel\actingAs;

function getUserAgent(): string
{
    return "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36";
}

it("creates a page view for a product", function () {
    $product = Product::factory()->create();
    $user = User::factory()->create();

    $pageView = app(CreatePageViewAction::class)->handle(
        ViewableType::PRODUCT,
        $product->id,
        getUserAgent(),
        [],
        $user,
        "192.168.0.1",
        "/products/" . $product->id
    );

    expect($pageView)
        ->toBeInstanceOf(PageView::class)
        ->and($pageView->viewable_type)
        ->toBe(Product::class)
        ->and($pageView->viewerable_type)
        ->toBe(User::class);

    expect($product->views()->count())->toBe(1);
    expect($product->viewsCount)->toBe(1);
    expect($product->latestView->id)->toBe($pageView->id);

    actingAs($user);

    expect($product->isViewedByCurrent)->toBeTrue();
    expect($user->views()->count())->toBe(1);
});

it("creates a page view for a category", function () {
    $category = Category::factory()->create();
    $guest = Guest::factory()->create();

    $pageView = app(CreatePageViewAction::class)->handle(
        ViewableType::CATEGORY,
        $category->id,
        getUserAgent(),
        [],
        $guest
    );

    expect($pageView->viewable_type)
        ->toBe(Category::class)
        ->and($pageView->viewerable_type)
        ->toBe(Guest::class);

    expect(value: $category->views()->count())->toBe(1);
});

it("creates a page view for a brand", function () {
    $brand = Brand::factory()->create();
    $user = User::factory()->create();

    $pageView = app(CreatePageViewAction::class)->handle(
        ViewableType::BRAND,
        $brand->id,
        getUserAgent(),
        [],
        $user
    );

    expect($pageView->viewable_type)
        ->toBe(Brand::class)
        ->and($pageView->viewerable_type)
        ->toBe(User::class);

    expect(value: $brand->views()->count())->toBe(1);
});

it("creates a page view for a tag", function () {
    $tag = Tag::factory()->create();
    $guest = Guest::factory()->create();

    $pageView = app(CreatePageViewAction::class)->handle(
        ViewableType::TAG,
        $tag->id,
        getUserAgent(),
        [],
        $guest
    );

    expect($pageView->viewable_type)
        ->toBe(Tag::class)
        ->and($pageView->viewerable_type)
        ->toBe(Guest::class);

    expect($tag->views()->count())->toBe(1);
});

it("throws an exception if the viewable is not found", function () {
    $user = User::factory()->create();

    app(CreatePageViewAction::class)->handle(
        ViewableType::PRODUCT,
        "non-existent-id",
        getUserAgent(),
        [],
        $user
    );
})->throws(ApiException::class, "Viewable not found");
