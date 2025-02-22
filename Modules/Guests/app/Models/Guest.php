<?php

namespace Modules\Guests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Guests\Database\Factories\GuestFactory;

class Guest
{
    /** @use HasFactory<\Modules\Guests\Database\Factories\GuestFactory> */
    use HasFactory, Authenticatable, Authorizable, HasApiTokens;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['totals'];
}
