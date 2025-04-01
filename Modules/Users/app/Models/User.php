<?php

namespace Modules\Users\Models;

use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Addresses\Models\Address;
use Modules\Carts\Models\Cart;
use Modules\CompareLists\Models\CompareList;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Users\Casts\UserTotalCast;
use Modules\Users\Database\Factories\UserFactory;
use Modules\Users\Enums\UserGender;
use Modules\Users\Enums\UserRole;
use Modules\Users\ValueObjects\UserTotals;
use Modules\Wishlists\Models\Wishlist;
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
     * user compare list
     * @return HasOne<CompareList, $this>
     */
    public function compareList(): HasOne
    {
        return $this->hasOne(CompareList::class);
    }
}
