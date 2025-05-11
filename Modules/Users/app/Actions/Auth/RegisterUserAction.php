<?php

namespace Modules\Users\Actions\Auth;

use Modules\Carts\Actions\MergeGuestCartToUserAction;
use Modules\Core\Services\Application;
use Modules\Guests\Models\Guest;
use Modules\Users\Enums\UserRole;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;
use Modules\Users\Notifications\NewCustomerNotification;
use Modules\Wishlists\Actions\MergeGuestWishlistToUserAction;

class RegisterUserAction
{
    /**
     * create user
     * @return array{User, string}
     */
    public function handle(array $data): array
    {
        $data["name"] = $data["first_name"] . " " . $data["last_name"];
        unset($data["first_name"], $data["last_name"]);

        $user = Customer::create([...$data, "role" => UserRole::CUSTOMER]);

        $access_token = $user->createToken(Application::getApplicationType())
            ->plainTextToken;

        /** @var Guest $guest */
        $guest = auth("guest")->user();
        // merge guest cart to user cart
        MergeGuestCartToUserAction::new()->handle($guest, $user);
        // merge guest wishlist to user wishlist
        MergeGuestWishlistToUserAction::new()->handle($guest, $user);

        rescue(fn() => $user->notify(new NewCustomerNotification()));

        return [$user, $access_token];
    }
}
