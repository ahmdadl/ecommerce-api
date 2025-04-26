<?php

use Modules\CompareLists\Http\Controllers\CompareListsController;
use Modules\Products\Models\Product;
use Modules\CompareLists\Models\CompareListItem;
use Modules\CompareLists\Transformers\CompareListResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Modules\Guests\Models\Guest;
use Modules\Users\Models\User;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

describe("CompareListsController", function () {
    test("only_authenticated_users_can_access_compare_list", function () {
        getJson(route("api.compare-list.index"))->assertUnauthorized();

        asGuest();
        getJson(route("api.compare-list.index"))->assertUnauthorized();
    });
    test("index returns compare list for authenticated user", function () {
        $user = User::factory()->customer()->create();
        $product = Product::factory()->create();

        asCustomer($user);

        compareListService()->addItem($product);

        assertDatabaseHas("compare_lists", [
            "id" => compareListService()->compareList->id,
            "user_id" => $user->id,
        ]);

        getJson(route("api.compare-list.index"))
            ->assertOk()
            ->assertSee($product->name);
    });

    test(
        "store adds product to compare list for authenticated user",
        function () {
            $user = User::factory()->create();
            $product = Product::factory()->create();

            asCustomer($user)
                ->postJson(route("api.compare-list.store", $product))
                ->assertOk()
                ->assertJsonCount(1, "data.compareList.items")
                ->assertJsonFragment(["product_id" => $product->id]);
        }
    );

    test("store fails when compare list is full", function () {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        asCustomer($user);

        CompareListItem::factory()
            ->for(compareListService()->compareList)
            ->count(10)
            ->create();

        postJson(route("api.compare-list.store", $product))
            ->assertStatus(400)
            ->assertJsonFragment([
                "message" => __("compareLists::t.list_is_full"),
            ]);
    });

    test(
        "destroy removes compare list item for authenticated user",
        function () {
            $user = User::factory()->create();
            $product = Product::factory()->create();

            asCustomer($user);

            $compareListItem = CompareListItem::factory()
                ->for(compareListService()->compareList)
                ->for($product)
                ->create();

            deleteJson(route("api.compare-list.destroy", $compareListItem))
                ->assertOk()
                ->assertJsonCount(0, "data.compareList.items");
        }
    );

    test("destroy fails for non-existent compare list item", function () {
        asCustomer()
            ->deleteJson(route("api.compare-list.destroy", 999))
            ->assertNotFound();
    });

    test(
        "destroy fails when compare list item is not for current user",
        function () {
            $user = User::factory()->create();
            $product = Product::factory()->create();

            asCustomer($user);

            $compareListItem = CompareListItem::factory()
                ->for($product)
                ->create();

            deleteJson(
                route("api.compare-list.destroy", $compareListItem)
            )->assertNotFound();
        }
    );

    test(
        "clear removes all compare list items for authenticated user",
        function () {
            $user = User::factory()->create();
            CompareListItem::factory()->count(3)->create();

            asCustomer($user)
                ->deleteJson(route("api.compare-list.clear"))
                ->assertOk()
                ->assertJsonCount(0, "data.compareList.items");
        }
    );
});
