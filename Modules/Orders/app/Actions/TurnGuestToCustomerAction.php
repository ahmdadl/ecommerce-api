<?php

namespace Modules\Orders\Actions;

use Modules\Core\Traits\HasActionHelpers;
use Modules\Users\Actions\Auth\RegisterUserAction;
use Modules\Users\Models\User;
use Modules\Users\Notifications\ChangeGuestPasswordNotification;

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
        rescue(
            fn() => $customer->notify(new ChangeGuestPasswordNotification())
        );

        return [$customer, $access_token];
    }
}
