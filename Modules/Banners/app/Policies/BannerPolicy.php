<?php

namespace Modules\Banners\Policies;

use Modules\Users\Models\User;
use Modules\Banners\Models\Banner;
use Illuminate\Auth\Access\HandlesAuthorization;

class BannerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Banner $banner): bool
    {
        return $user->can("view_banner");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("create_banner");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Banner $banner): bool
    {
        return $user->can("update_banner");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Banner $banner): bool
    {
        return $user->can("delete_banner");
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Banner $banner): bool
    {
        return $user->can("replicate_banner");
    }
}
