<?php

namespace Modules\Orders\Actions;

use Modules\Carts\Actions\CreateShippingAddressAction;
use Modules\Core\Traits\HasActionHelpers;

class CreateGuestOrderAction
{
    use HasActionHelpers;

    public function __construct(
        private TurnGuestToCustomerAction $createCustomerAction,
        private CreateShippingAddressAction $createShippingAddressAction,
        private CreateOrderFromCartAction $createOrderAction
    ) {}

    public function handle(array $validatedData): array
    {
        // create user
        [$user] = $this->createCustomerAction->handle(
            $validatedData["address"]
        );

        // create shipping address
        $addressData = $validatedData["address"];
        unset(
            $addressData["government"],
            $addressData["city"],
            $addressData["user_id"]
        );
        $address = $this->createShippingAddressAction->handle([
            ...$addressData,
            "is_default" => true,
        ]);

        // create order
        $order = $this->createOrderAction->handle(
            cartService()->cart,
            $validatedData["payment_method"],
            $validatedData["receipt"]
        );

        return [$user, $order, $address];
    }
}
