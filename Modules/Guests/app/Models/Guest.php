<?php

namespace Modules\Guests\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as AuthenticatableModel;
use Laravel\Sanctum\HasApiTokens;
use Modules\Carts\Models\Cart;
use Modules\Carts\Models\CartItem;
use Modules\Guests\Database\Factories\GuestFactory;
use Modules\Users\Casts\UserTotalCast;
use Modules\Users\ValueObjects\UserTotals;
use Modules\Wishlists\Models\Wishlist;
use Modules\Wishlists\Models\WishlistItem;

#[UseFactory(GuestFactory::class)]
class Guest extends AuthenticatableModel
{
    /** @use HasFactory<\Modules\Guests\Database\Factories\GuestFactory> */
    use Authenticatable, Authorizable, HasApiTokens, HasFactory, HasUlids;

    /**
     * handle mode casts
     */
    protected function casts(): array
    {
        return [
            "totals" => UserTotalCast::class,
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $user) {
            $user->totals = UserTotals::default();
        });
    }

    /**
     * is guest
     * @return Attribute<boolean, void>
     */
    public function isGuest(): Attribute
    {
        return Attribute::make(get: fn() => true);
    }

    /**
     * is customer
     * @return Attribute<boolean, void>
     */
    public function isCustomer(): Attribute
    {
        return Attribute::make(get: fn() => false);
    }

    /**
     * user cart
     * @return MorphOne<Cart, $this>
     */
    public function cart(): MorphOne
    {
        return $this->morphOne(Cart::class, "cartable");
    }

    /**
     * user cart items
     * @return HasManyThrough<CartItem, Cart, $this>
     */
    public function cartItems(): HasManyThrough
    {
        return $this->hasManyThrough(
            CartItem::class,
            Cart::class,
            "cartable_id"
        );
    }

    /**
     * user wishlist
     * @return MorphOne<Wishlist, $this>
     */
    public function wishlist(): MorphOne
    {
        return $this->morphOne(Wishlist::class, "wishlistable");
    }

    /**
     * guest wishlist items
     * @return HasManyThrough<WishlistItem, Wishlist, $this>
     */
    public function wishlistItems(): HasManyThrough
    {
        return $this->hasManyThrough(
            WishlistItem::class,
            Wishlist::class,
            "wishlistable_id"
        );
    }
}
