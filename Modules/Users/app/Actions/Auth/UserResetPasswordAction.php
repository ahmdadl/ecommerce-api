<?php

namespace Modules\Users\Actions\Auth;

use Illuminate\Support\Facades\Hash;
use Modules\Core\Exceptions\ApiException;
use Modules\Users\Models\Auth\PasswordResetToken;
use Modules\Users\Models\Customer;
use Throwable;

class UserResetPasswordAction
{
    public function handle(array $data): ?Throwable
    {
        ["email" => $email, "password" => $password, "token" => $token] = $data;

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

        return null;
    }
}
