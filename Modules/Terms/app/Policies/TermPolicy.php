<?php

namespace Modules\Terms\Policies;

use Modules\Users\Models\Admin;
use Modules\Terms\Models\Term;
use Illuminate\Auth\Access\HandlesAuthorization;

class TermPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can("create_term");
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Term $term): bool
    {
        return $admin->can("update_term");
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Term $term): bool
    {
        return $admin->can("delete_term");
    }

    /**
     * Determine whether the admin can replicate.
     */
    public function replicate(Admin $admin, Term $term): bool
    {
        return $admin->can("replicate_term");
    }

    /**
     * Determine whether the admin can reorder.
     */
    public function reorder(Admin $admin): bool
    {
        return $admin->can("reorder_term");
    }
}
