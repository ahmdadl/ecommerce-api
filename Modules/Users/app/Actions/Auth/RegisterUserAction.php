<?php

namespace Modules\Users\Actions\Auth;

use Modules\Carts\Actions\MergeGuestCartToUserAction;
use Modules\Core\Services\Application;
use Modules\Guests\Models\Guest;
use Modules\Users\Enums\UserRole;
use Modules\Users\Models\User;
use Modules\Wishlists\Actions\MergeGuestWishlistToUserAction;

class RegisterUserAction
{
    public function handle(array $data): ?User
    {
        $data["name"] = $data["first_name"] . " " . $data["last_name"];
        unset($data["first_name"], $data["last_name"]);

        $user = User::create([...$data, "role" => UserRole::CUSTOMER]);

        $user->access_token = $user->createToken(
            Application::getApplicationType()
        )->plainTextToken;

        /** @var Guest $guest */
        $guest = auth("guest")->user();
        // merge guest cart to user cart
        MergeGuestCartToUserAction::new()->handle($guest, $user);
        // merge guest wishlist to user wishlist
        MergeGuestWishlistToUserAction::new()->handle($guest, $user);

        return $user;
    }
}
