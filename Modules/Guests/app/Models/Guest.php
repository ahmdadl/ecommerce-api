<?php

namespace Modules\Guests\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as AuthenticatableModel;
use Laravel\Sanctum\HasApiTokens;
use Modules\Guests\Database\Factories\GuestFactory;
use Modules\Users\Casts\UserTotalCast;
use Modules\Users\ValueObjects\UserTotals;

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
            'totals' => UserTotalCast::class,
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
}
