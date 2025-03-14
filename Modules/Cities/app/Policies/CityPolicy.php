<?php

namespace Modules\Cities\Policies;

use Modules\Users\Models\User;
use Modules\Cities\Models\City;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, City $city): bool
    {
        return $user->can("view_city");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("create_city");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, City $city): bool
    {
        return $user->can("update_city");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, City $city): bool
    {
        return $user->can("delete_city");
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, City $city): bool
    {
        return $user->can("restore_city");
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, City $city): bool
    {
        return $user->can("replicate_city");
    }
}
