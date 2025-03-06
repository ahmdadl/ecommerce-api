<?php

namespace Modules\Users\Actions\Auth;

use Modules\Core\Services\Application;
use Modules\Users\Models\User;

class RegisterUserAction
{
    public function handle(array $data): ?User
    {
        $data['name'] = $data['firstName'].' '.$data['lastName'];
        unset($data['firstName'], $data['lastName']);

        $user = User::create($data);

        $user->access_token = $user->createToken(Application::getApplicationType())->plainTextToken;

        return $user;
    }
}
