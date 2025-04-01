<?php

namespace Modules\Guests\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as AuthenticatableModel;
use Laravel\Sanctum\HasApiTokens;
use Modules\Carts\Models\Cart;
use Modules\Guests\Database\Factories\GuestFactory;
use Modules\Users\Casts\UserTotalCast;
use Modules\Users\ValueObjects\UserTotals;
use Modules\Wishlists\Models\Wishlist;

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
     * user cart
     * @return MorphOne<Cart, $this>
     */
    public function cart(): MorphOne
    {
        return $this->morphOne(Cart::class, "cartable");
    }

    /**
     * user wishlist
     * @return MorphOne<Wishlist, $this>
     */
    public function wishlist(): MorphOne
    {
        return $this->morphOne(Wishlist::class, "wishlistable");
    }
}
