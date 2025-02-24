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
use Modules\Users\Database\Factories\UserFactory;
use Modules\Users\Enums\UserRole;

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
        ];
    }

    /**
     * Scope a query to only include users with the specified role.
     * 
     * @param Builder<User> $query
     */
    public function scopeRole(Builder $query, ?UserRole $userRole = null): void
    {
        $query->where('role', $userRole ?? $this->role);
    }

    /**
     * Find a user by the given credentials.
     * 
     * @param array<string, mixed> $credentials
     * @param string|null $guard
     * @param bool $remember
     */
    public static function attempt(array $credentials, ?string $guard = null, bool $remember = false): bool
    {
        return auth()->guard($guard)->attempt(array_merge($credentials, ['role' => static::$role?->value]), $remember);
    }
}
