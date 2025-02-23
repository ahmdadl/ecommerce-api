<?php

namespace Modules\Users\Models;

use Modules\Users\Enums\UserRole;

class Developer extends User
{
    /**
     * current model role
     */
    public static ?UserRole $role = UserRole::DEVELOPER;
}
