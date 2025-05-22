<?php

namespace Modules\Core\Actions;

use Modules\Users\Models\User;
use Modules\Carts\Transformers\CartResource;
use Modules\Guests\Models\Guest;
use Modules\Guests\Transformers\GuestResource;
use Modules\Users\Models\Customer;
use Modules\Users\Transformers\CustomerResource;
use Modules\Wishlists\Transformers\WishlistResource;

class GetInitialDataAction
{
    public function handle(User|Customer|Guest $user): array
    {
        $response = [];

        // get current user or guest
        $isGuest = $user instanceof Guest;
        if ($isGuest) {
            /** @var Guest $user */
            $user->role = "guest";
        } else {
            /** @var User $user */
            $user->withRole = true;
        }
        $response["user"] = $isGuest
            ? new GuestResource($user)
            : new CustomerResource($user);

        // get current cart
        $user->cart?->loadMissing("items.product");
        $response["cart"] = $user->cart ? new CartResource($user->cart) : null;

        // get current wishlist
        $user->wishlist?->loadMissing("items.product");
        $response["wishlist"] = $user->wishlist
            ? new WishlistResource($user->wishlist)
            : null;

        return $response;
    }
}
