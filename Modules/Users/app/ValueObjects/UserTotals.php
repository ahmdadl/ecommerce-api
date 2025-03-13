<?php

namespace Modules\Users\ValueObjects;

use Livewire\Wireable;
use Modules\Core\Traits\WireableValueObject;

final class UserTotals implements Wireable
{
    use WireableValueObject;

    /**
     * construct object
     */
    public function __construct(
        public int $cartItems,
        public int $wishlistItems,
        public int $comparedItems,
        public int $orders,
        public int $totalPurchased
    ) {}

    /**
     * Convert the object to an array
     */
    public function toArray(): array
    {
        return [
            "cartItems" => $this->cartItems,
            "wishlistItems" => $this->wishlistItems,
            "comparedItems" => $this->comparedItems,
            "orders" => $this->orders,
            "totalPurchased" => $this->totalPurchased,
        ];
    }

    /**
     * Create a Totals object from an array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            cartItems: $data["cartItems"],
            wishlistItems: $data["wishlistItems"],
            comparedItems: $data["comparedItems"],
            orders: $data["orders"],
            totalPurchased: $data["totalPurchased"]
        );
    }

    /**
     * get default totals
     */
    public static function default(): self
    {
        return new self(
            cartItems: 0,
            wishlistItems: 0,
            comparedItems: 0,
            orders: 0,
            totalPurchased: 0
        );
    }

    /**
     * recalculate totals
     */
    public static function recalculate(): self
    {
        // todo implement calculations
        return new self(
            cartItems: 0,
            wishlistItems: 0,
            comparedItems: 0,
            orders: 0,
            totalPurchased: 0
        );
    }

    /**
     * turn object to json string
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) json_encode($this->toArray());
    }
}
