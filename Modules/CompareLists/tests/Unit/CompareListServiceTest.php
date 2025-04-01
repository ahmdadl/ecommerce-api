<?php

use Modules\Guests\Models\Guest;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;
use Modules\CompareLists\Models\CompareList;
use Modules\CompareLists\Models\CompareListItem;
use Modules\CompareLists\Services\CompareListService;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

describe("CompareListService", function () {
    it("can_add_product_to_compareList", function () {
        $compareList = CompareList::factory()->create();
        $product = Product::factory()->create();

        $compareListService = new CompareListService($compareList);
        $compareListService->addItem($product);

        expect($compareList->items()->count())->toBe(1);

        assertDatabaseHas("compare_list_items", [
            "compare_list_id" => $compareList->id,
            "product_id" => $product->id,
        ]);
    });

    it("can_remove_product_from_compareList", function () {
        $compareList = CompareList::factory()->create();
        $product = Product::factory()->create();

        $compareListService = new CompareListService($compareList);
        $compareListService->addItem($product);

        expect($compareList->items()->count())->toBe(1);

        $compareListService->removeItem($compareList->items()->first());

        expect($compareList->items()->count())->toBe(0);

        assertDatabaseMissing("compare_list_items", [
            "compare_list_id" => $compareList->id,
            "product_id" => $product->id,
        ]);
    });

    test("compareList_is_created_directly_for_current_user", function () {
        actingAs(User::factory()->customer()->create());

        $compareListService = app(CompareListService::class);

        expect($compareListService->compareList)->toBeInstanceOf(
            CompareList::class
        );

        assertDatabaseHas("compare_lists", [
            "user_id" => user()->id,
        ]);
    });

    it("has_compareList_helper_method", function () {
        actingAs(User::factory()->customer()->create());

        expect(compareListService())->toBeInstanceOf(CompareListService::class);
    });

    it("has_count_method", function () {
        $compareList = CompareList::factory()->create();
        $compareListService = new CompareListService($compareList);

        expect($compareListService->count())->toBe(0);
    });

    it("has_has_product_method", function () {
        $compareList = CompareList::factory()->create();
        $product = Product::factory()->create();

        $compareListService = new CompareListService($compareList);

        expect($compareListService->hasProduct($product))->toBe(false);

        $compareListService->addItem($product);

        expect($compareListService->hasProduct($product))->toBe(true);
    });

    it("has_is_empty_compareList_method", function () {
        $compareList = CompareList::factory()->create();
        $compareListService = new CompareListService($compareList);

        expect($compareListService->isEmpty())->toBe(true);
    });

    it("has_clear_compareList_method", function () {
        $compareList = CompareList::factory()->create();
        $compareListService = new CompareListService($compareList);

        $compareListService->addItem(Product::factory()->create());

        expect($compareListService->isEmpty())->toBe(false);

        $compareListService->clear();

        expect($compareListService->isEmpty())->toBe(true);
    });

    it("updates_user_total_compareList_items", function () {
        $user = User::factory()->customer()->create();
        $compareList = CompareList::factory()->for($user, "user")->create();
        $compareListService = new CompareListService($compareList);

        $compareListService->addItem(Product::factory()->create());

        $user->refresh();
        expect($user->totals->compareItems)->toBe(1);
        expect($compareListService->count())->toBe(1);

        $compareListService->removeItem(CompareListItem::first());

        expect($compareListService->count())->toBe(0);
        $user->refresh();
        expect($user->totals->compareItems)->toBe(0);

        $compareListService->addItem(Product::factory()->create());
        $compareListService->addItem(Product::factory()->create());

        $user->refresh();
        expect($user->totals->compareItems)->toBe(2);

        $compareListService->clear();

        $user->refresh();
        expect($user->totals->compareItems)->toBe(0);
    });
});
