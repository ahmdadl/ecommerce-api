<?php

namespace Modules\Users\ValueObjects;

use Livewire\Wireable;
use Modules\Core\Traits\WireableValueObject;
use Modules\Guests\Models\Guest;
use Modules\Users\Enums\UserTotalsKey;
use Modules\Users\Models\User;

final class UserTotals implements Wireable
{
    use WireableValueObject;

    /**
     * construct object
     */
    public function __construct(
        public int $cartItems,
        public int $wishlistItems,
        public int $compareItems,
        public int $orders,
        public int $purchased
    ) {}

    /**
     * Convert the object to an array
     */
    public function toArray(): array
    {
        return [
            "cart_items" => $this->cartItems,
            "wishlist_items" => $this->wishlistItems,
            "compare_items" => $this->compareItems,
            "orders" => $this->orders,
            "purchased" => $this->purchased,
        ];
    }

    /**
     * Create a Totals object from an array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            cartItems: $data["cart_items"],
            wishlistItems: $data["wishlist_items"],
            compareItems: $data["compare_items"],
            orders: $data["orders"],
            purchased: $data["purchased"]
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
            compareItems: 0,
            orders: 0,
            purchased: 0
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
            compareItems: 0,
            orders: 0,
            purchased: 0
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

    /**
     * update user or guest totals
     */
    public static function update(
        User|Guest $user,
        UserTotalsKey $key,
        int $value
    ): void {
        $user->update(["totals->$key->value" => $value]);
    }
}
