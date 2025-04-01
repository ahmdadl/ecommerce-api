<?php

namespace Modules\Users\Actions\Auth;

use Modules\Carts\Actions\MergeGuestCartToUserAction;
use Modules\Core\Services\Application;
use Modules\Guests\Models\Guest;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;
use Modules\Wishlists\Actions\MergeGuestWishlistToUserAction;

class LoginUserAction
{
    public function handle(array $credentials): ?User
    {
        if (!Customer::attempt($credentials)) {
            return null;
        }

        /** @var Guest $guest */
        $guest = auth("guest")->user();

        /** @var User $user */
        $user = auth("customer")->user();
        $user = new Customer($user->toArray());

        $accessToken = $user->createToken(Application::getApplicationType())
            ->plainTextToken;

        $user->access_token = $accessToken;

        // merge guest cart to user cart
        MergeGuestCartToUserAction::new()->handle($guest, $user);
        // merge guest wishlist to user wishlist
        MergeGuestWishlistToUserAction::new()->handle($guest, $user);

        return $user;
    }
}
