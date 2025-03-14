<?php

namespace Modules\Governments\Policies;

use Modules\Users\Models\User;
use Modules\Governments\Models\Government;
use Illuminate\Auth\Access\HandlesAuthorization;

class GovernmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Government $government): bool
    {
        return $user->can("view_government");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("create_government");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Government $government): bool
    {
        return $user->can("update_government");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Government $government): bool
    {
        return $user->can("delete_government");
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Government $government): bool
    {
        return $user->can("restore_government");
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Government $government): bool
    {
        return $user->can("replicate_government");
    }
}
