<?php

namespace Modules\Wishlists\Actions;

use Modules\Core\Traits\HasActionHelpers;
use Modules\Guests\Models\Guest;
use Modules\Users\Models\User;
use Modules\Wishlists\Services\WishlistService;

class MergeGuestWishlistToUserAction
{
    use HasActionHelpers;

    public function handle(Guest $guest, User $user)
    {
        $guestWishlist = $guest->wishlist;
        if (!$guestWishlist || $guestWishlist->items->count() === 0) {
            return; // no need for merge
        }
        $guestWishlistService = new WishlistService($guestWishlist);

        // check if user does not have wishlist or his wishlist is empty
        // THEN just set current guest wishlist to user wishlist
        $userWishlist = $user->wishlist;
        if (!$userWishlist || $userWishlist->items->count() === 0) {
            $guestWishlist->wishlistable()->associate($user);
            $guestWishlistService->save();
            return;
        }

        // user have wishlist and it is not empty
        // THEN just add guest wishlist items to user wishlist
        $userWishlistService = new WishlistService($userWishlist);
        $guestWishlist->items->loadMissing("product");

        foreach ($guestWishlist->items as $guestWishlistItem) {
            rescue(
                fn() => (new AddToWishlistAction($userWishlistService))->handle(
                    $guestWishlistItem->product
                ),
                report: false
            );
        }

        // clear guest wishlist
        $guestWishlist->items()->delete();
        $guestWishlist->delete();
    }
}
