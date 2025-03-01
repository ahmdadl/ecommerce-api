<?php

namespace Modules\Users\Actions;

use Modules\Core\Services\Application;
use Modules\Users\Enums\UserRole;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;

class LoginUserAction
{
    public function handle(array $credentials): ?User
    {
        if (!Customer::attempt($credentials)) {
            return null;
        }

        /** @var User $user */
        $user = auth('customer')->user();

        $accessToken = $user->createToken(Application::getApplicationType())->plainTextToken;

        $user->access_token = $accessToken;

        return $user;
    }
}
