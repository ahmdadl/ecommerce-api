<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Enums\UserRole;
use Modules\Users\Traits\RoleCheck;

class Customer extends User
{
    use RoleCheck;

    protected $table = "users";

    /**
     * current use role
     */
    protected string $role = UserRole::CUSTOMER->value;
}
