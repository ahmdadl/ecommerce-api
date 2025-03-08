<?php

namespace Modules\Brands\Policies;

use Modules\Users\Models\User;
use Modules\Brands\Models\Brand;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Brand $brand): bool
    {
        return $user->can("view_brand");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("create_brand");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Brand $brand): bool
    {
        return $user->can("update_brand");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Brand $brand): bool
    {
        return $user->can("delete_brand");
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Brand $brand): bool
    {
        return $user->can("restore_brand");
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Brand $brand): bool
    {
        return $user->can("replicate_brand");
    }
}
