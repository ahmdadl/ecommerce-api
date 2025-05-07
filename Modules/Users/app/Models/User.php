<?php

namespace Modules\Users\Models;

use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Addresses\Models\Address;
use Modules\Carts\Models\Cart;
use Modules\Carts\Models\CartItem;
use Modules\CompareLists\Models\CompareList;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\PageViews\Models\PageView;
use Modules\Users\Casts\UserTotalCast;
use Modules\Users\Database\Factories\UserFactory;
use Modules\Users\Enums\UserGender;
use Modules\Users\Enums\UserRole;
use Modules\Users\Notifications\NewCustomerNotification;
use Modules\Users\ValueObjects\UserTotals;
use Modules\Wallets\Models\Wallet;
use Modules\Wishlists\Models\Wishlist;
use Modules\Wishlists\Models\WishlistItem;
use Spatie\Permission\Traits\HasRoles;

#[UseFactory(UserFactory::class)]
class User extends Authenticatable
{
    /** @use HasFactory<\Modules\Users\Database\Factories\UserFactory> */
    use HasActiveState,
        HasApiTokens,
        HasFactory,
        HasUlids,
        Notifiable,
        SoftDeletes,
        HasRoles;

    /**
     * current model role
     */
    public static ?UserRole $role = null;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
            "totals" => UserTotalCast::class,
            "gender" => UserGender::class,
            "role" => UserRole::class,
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $user) {
            if (!is_null(static::$role)) {
                $user->role = static::$role;
            }
            $user->totals = UserTotals::default();

            if (empty($user->is_active) && $user->is_active !== false) {
                $user->is_active = true;
            }
        });
    }

    /**
     * Scope a query to only include users with the specified role.
     *
     * @param  Builder<User>  $query
     */
    public function scopeRole(Builder $query, ?UserRole $userRole = null): void
    {
        $query->where("role", $userRole ?? static::$role?->value);
    }

    /**
     * Find a user by the given credentials.
     */
    public static function attempt(
        array $credentials,
        bool $remember = false
    ): bool {
        return auth()
            ->guard("web")
            ->attempt(
                array_merge($credentials, ["role" => static::$role?->value]),
                $remember
            );
    }

    /**
     * is guest
     * @return Attribute<boolean, void>
     */
    public function isGuest(): Attribute
    {
        return Attribute::make(get: fn() => false);
    }

    /**
     * is customer
     * @return Attribute<boolean, void>
     */
    public function isCustomer(): Attribute
    {
        return Attribute::make(
            get: fn() => static::$role === UserRole::CUSTOMER
        )->shouldCache();
    }

    /**
     * who can access admin dashboard
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return static::$role === UserRole::ADMIN;
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
     * get user addresses
     * @return HasMany<Address, $this>
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
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
     * user wishlist items
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

    /**
     * user compare list
     * @return HasOne<CompareList, $this>
     */
    public function compareList(): HasOne
    {
        return $this->hasOne(CompareList::class, "user_id");
    }

    /**
     * views
     * @return MorphMany<PageView, $this>
     */
    public function views(): MorphMany
    {
        return $this->morphMany(PageView::class, "viewerable");
    }

    /**
     * wallet
     * @return HasOne<Wallet, $this>
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, "user_id");
    }
}
