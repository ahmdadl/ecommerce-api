<?php

namespace Modules\Guests\Models;

use Database\Factories\TestFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Guests\Database\Factories\GuestFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

#[UseFactory(GuestFactory::class)]
class Guest extends Model
{
    /** @use HasFactory<\Modules\Guests\Database\Factories\GuestFactory> */
    use HasFactory, Authenticatable, Authorizable, HasApiTokens, HasUlids;
}
