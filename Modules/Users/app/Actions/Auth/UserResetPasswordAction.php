<?php

namespace Modules\Users\Actions\Auth;

use Illuminate\Support\Facades\Hash;
use Modules\Carts\Actions\MergeGuestCartToUserAction;
use Modules\Core\Exceptions\ApiException;
use Modules\Core\Services\Application;
use Modules\Guests\Models\Guest;
use Modules\Users\Models\Auth\PasswordResetToken;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;
use Modules\Wishlists\Actions\MergeGuestWishlistToUserAction;
use Throwable;

class UserResetPasswordAction
{
    public function handle(array $data): Throwable|User
    {
        ["email" => $email, "password" => $password, "otp" => $token] = $data;

        $user = Customer::role()->active()->whereEmail($email)->first();

        if (!$user) {
            throw new ApiException(__("users::t.invalid_credentials"));
        }

        $passwordReset = PasswordResetToken::whereToken($token)
            ->whereEmail($email)
            ->first();

        if (!$passwordReset) {
            throw new ApiException(__("users::t.invalid_token"));
        }

        if ($passwordReset->created_at->addMinutes(5)->isPast()) {
            throw new ApiException(__("users::t.token_expired"));
        }

        $user->password = Hash::make($password);
        $user->save();

        $passwordReset->delete();

        // log user in
        auth("customer")->setUser($user);
        $accessToken = $user->createToken(Application::getApplicationType())
            ->plainTextToken;
        $user->access_token = $accessToken;

        /** @var Guest $guest */
        $guest = auth("guest")->user();
        // merge guest cart to user cart
        MergeGuestCartToUserAction::new()->handle($guest, $user);
        // merge guest wishlist to user wishlist
        MergeGuestWishlistToUserAction::new()->handle($guest, $user);

        return $user;
    }
}
