<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Enums\UserRole;

class Customer extends User
{
    protected $table = "users";

    /**
     * current model role
     */
    public static ?UserRole $role = UserRole::CUSTOMER;
}
