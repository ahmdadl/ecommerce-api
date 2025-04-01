<?php

namespace Modules\Carts\Actions;

use Modules\Carts\Services\CartService;
use Modules\Core\Traits\HasActionHelpers;
use Modules\Guests\Models\Guest;
use Modules\Users\Models\User;

class MergeGuestCartToUserAction
{
    use HasActionHelpers;

    public function handle(Guest $guest, User $user)
    {
        $guestCart = $guest->cart;
        if (!$guestCart || $guestCart->totals->items === 0) {
            return; // no need for merge
        }
        $guestCartService = new CartService($guestCart);

        $userCart = $user->cart;

        // check if user does not have cart or his cart is empty
        // THEN just set current guest cart to user cart
        if (!$userCart || $userCart->totals->items === 0) {
            $guestCart->cartable()->associate($user);

            $guestCartService->save();

            return;
        }

        // user have cart and it is not empty
        // THEN just add guest cart items to user cart
        $userCartService = new CartService($userCart);

        $guestCart->items->loadMissing("product");
        foreach ($guestCart->items as $guestCartItem) {
            try {
                $userCartItem = $userCartService->findCartItemByProduct(
                    $guestCartItem->product
                );
                if ($userCartItem) {
                    (new UpdateCartAction($userCartService))->handle(
                        $userCartItem,
                        $guestCartItem->quantity + $userCartItem->quantity
                    );
                } else {
                    (new AddToCartAction($userCartService))->handle(
                        $guestCartItem->product,
                        $guestCartItem->quantity
                    );
                }
            } catch (\Throwable) {
                // nothing
            }
        }

        // remove guest cart
        $guestCart->items()->delete();
        $guestCart->delete();

        return;
    }
}
