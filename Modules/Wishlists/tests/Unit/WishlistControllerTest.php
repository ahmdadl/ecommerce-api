<?php

use Modules\Wishlists\Http\Controllers\WishlistsController;
use Modules\Products\Models\Product;
use Modules\Wishlists\Models\WishlistItem;
use Modules\Wishlists\Transformers\WishlistResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Modules\Guests\Models\Guest;
use Modules\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

describe("WishlistsController", function () {
    test("index returns wishlist for authenticated user", function () {
        $user = User::factory()->customer()->create();
        $product = Product::factory()->create();

        asCustomer($user);

        wishlistService()->addItem($product);

        assertDatabaseHas("wishlists", [
            "id" => wishlistService()->wishlist->id,
            "wishlistable_id" => $user->id,
        ]);

        getJson(route("api.wishlist.index"))
            ->assertOk()
            ->assertSee($product->name);
    });

    test("index returns empty wishlist for guest", function () {
        asGuest()
            ->getJson(route("api.wishlist.index"))
            ->assertOk()
            ->assertJsonCount(0, "data.record.items");
    });

    test("store adds product to wishlist for authenticated user", function () {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        asCustomer($user)
            ->postJson(route("api.wishlist.store", $product))
            ->assertOk()
            ->assertJsonCount(1, "data.record.items")
            ->assertJsonFragment(["product_id" => $product->id]);
    });

    test("store fails when wishlist is full", function () {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        asCustomer($user);
        WishlistItem::factory()
            ->for(wishlistService()->wishlist)
            ->count(10)
            ->create();

        postJson(route("api.wishlist.store", $product))
            ->assertStatus(400)
            ->assertJsonFragment([
                "message" => __("wishlists::t.wishlist_is_full"),
            ]);
    });

    test("destroy removes wishlist item for authenticated user", function () {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        asCustomer($user);

        $wishlistItem = WishlistItem::factory()
            ->for(wishlistService()->wishlist)
            ->for($product)
            ->create();

        deleteJson(route("api.wishlist.destroy", $wishlistItem))
            ->assertOk()
            ->assertJsonCount(0, "data.record.items");
    });

    test("destroy fails for non-existent wishlist item", function () {
        asCustomer()
            ->deleteJson(route("api.wishlist.destroy", 999))
            ->assertNotFound();
    });

    test(
        "destroy fails when wishlist item is not for current user",
        function () {
            $user = User::factory()->create();
            $product = Product::factory()->create();

            asCustomer($user);

            $wishlistItem = WishlistItem::factory()->for($product)->create();

            deleteJson(
                route("api.wishlist.destroy", $wishlistItem)
            )->assertNotFound();
        }
    );

    test(
        "clear removes all wishlist items for authenticated user",
        function () {
            $user = User::factory()->create();
            WishlistItem::factory()->count(3)->create();

            asCustomer($user)
                ->deleteJson(route("api.wishlist.clear"))
                ->assertOk()
                ->assertJsonCount(0, "data.record.items");
        }
    );

    test("clear works for guest user", function () {
        $guest = Guest::factory()->create();
        $product = Product::factory()->create();

        asGuest($guest);
        wishlistService()->addItem($product);

        expect(wishlistService()->wishlist->wishlistable->id)->toBe($guest->id);
        expect(wishlistService()->count())->toBe(1);

        deleteJson(route("api.wishlist.clear"))
            ->assertOk()
            ->assertJsonCount(0, "data.record.items");
    });
});
