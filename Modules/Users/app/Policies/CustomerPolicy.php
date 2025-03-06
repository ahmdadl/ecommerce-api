<?php

namespace Modules\Users\Policies;

use Modules\Users\Models\User;
use Modules\Users\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Customer $customer): bool
    {
        return $user->can("view_customer");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("create_customer");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Customer $customer): bool
    {
        return $user->can("update_customer");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Customer $customer): bool
    {
        return $user->can("delete_customer");
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Customer $customer): bool
    {
        return $user->can("restore_customer");
    }
}
