<?php

namespace Modules\Carts\Actions;

use Modules\Addresses\Models\Address;
use Modules\Carts\Services\CartService;

class CreateCartAddressAction
{
    public function __construct(public CartService $cartService) {}

    public function handle(array $validatedData): Address
    {
        $address = Address::create([
            "user_id" => user()->id,
            ...$validatedData,
        ]);

        $this->cartService->setAddress($address);

        return $address;
    }
}
