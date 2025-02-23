<?php

namespace Modules\Guests\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Guests\Database\Factories\GuestFactory;

#[UseFactory(GuestFactory::class)]
class Guest extends Model
{
    /** @use HasFactory<\Modules\Guests\Database\Factories\GuestFactory> */
    use Authenticatable, Authorizable, HasApiTokens, HasFactory, HasUlids;
}
