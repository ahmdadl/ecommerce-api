<?php

use Modules\Guests\Models\Guest;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;
use Modules\Wishlists\Actions\MergeGuestWishlistToUserAction;
use Modules\Wishlists\Models\Wishlist;
use Modules\Wishlists\Services\WishlistService;

it("merges_wishlist_to_user_without_wishlist", function () {
    $guest = Guest::factory()->create();
    Wishlist::factory()->for($guest, "wishlistable")->create();
    $guestCartService = new WishlistService($guest->wishlist);
    $guestCartService->addItem(Product::factory()->create());
    $guestCartService->addItem(Product::factory()->create());

    $user = User::factory()->create();

    expect($user->wishlist)->toBeNull();

    MergeGuestWishlistToUserAction::new()->handle($guest, $user);

    $user->refresh();
    expect($user->wishlist)->not->toBeNull();
    expect($user->wishlist->items()->count())->toBe(2);
});

it("merges_wishlist_to_user_with_wishlist_bypassing_errors", function () {
    $guest = Guest::factory()->create();
    Wishlist::factory()->for($guest, "wishlistable")->create();
    $guestCartService = new WishlistService($guest->wishlist);
    collect([])->times(
        10,
        fn() => $guestCartService->addItem(Product::factory()->create())
    );

    $user = User::factory()->create();
    Wishlist::factory()->for($user, "wishlistable")->create();
    $userWishlistService = new WishlistService($user->wishlist);
    $userWishlistService->addItem(Product::factory()->create());
    $userWishlistService->addItem(Product::factory()->create());

    expect($user->wishlist)->not->toBeNull();
    expect($user->wishlist->items()->count())->toBe(2);

    MergeGuestWishlistToUserAction::new()->handle($guest, $user);

    $user->refresh();
    expect($user->wishlist)->not->toBeNull();
    expect($user->wishlist->items()->count())->toBe(10);
});
