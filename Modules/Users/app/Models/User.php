<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Services\Application;
use Modules\Users\Casts\UserTotalCast;
use Modules\Users\Database\Factories\UserFactory;
use Modules\Users\Enums\UserGender;
use Modules\Users\Enums\UserRole;
use Modules\Users\ValueObjects\UserTotals;

#[UseFactory(UserFactory::class)]
class User extends Authenticatable
{
    /** @use HasFactory<\Modules\Users\Database\Factories\UserFactory> */
    use HasActiveState, HasFactory, HasUlids, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * current model role
     */
    public static ?UserRole $role = null;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'totals' => UserTotalCast::class,
            'gender' => UserGender::class,
            'role' => UserRole::class,
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
     * @param Builder<User> $query
     */
    public function scopeRole(Builder $query, ?UserRole $userRole = null): void
    {
        $query->where('role', $userRole ?? static::$role?->value);
    }

    /**
     * Find a user by the given credentials.
     * 
     * @param array<string, mixed> $credentials
     * @param string|null $guard
     * @param bool $remember
     */
    public static function attempt(array $credentials, bool $remember = false): bool
    {
        return auth()->guard('web')->attempt(array_merge($credentials, ['role' => static::$role?->value]), $remember);
    }
}
