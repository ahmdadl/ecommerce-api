<?php

namespace Modules\Users\Models;

use Modules\Users\Enums\UserRole;
use Modules\Users\Traits\RoleCheck;

class Admin extends User
{
    use RoleCheck;

    /**
     * current use role
     */
    protected string $role = UserRole::ADMIN->value;
}
