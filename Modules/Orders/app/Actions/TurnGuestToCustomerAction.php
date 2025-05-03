<?php

namespace Modules\Orders\Actions;

use Modules\Core\Traits\HasActionHelpers;
use Modules\Users\Actions\Auth\RegisterUserAction;
use Modules\Users\Models\User;

class TurnGuestToCustomerAction
{
    use HasActionHelpers;

    public function __construct(
        private RegisterUserAction $registerUserAction
    ) {}

    /**
     * create user from guest address
     * @return array{User, string}
     */
    public function handle(array $data): array
    {
        [$customer, $access_token] = $this->registerUserAction->handle([
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"],
            "email" => $data["email"],
            "phone" => $data["phone"],
            "password" => str()->random(10),
        ]);

        auth()->setUser($customer);

        // notify customer about password
        // $customer->notify(new ForgetPasswordNotification($customer));

        return [$customer, $access_token];
    }
}
