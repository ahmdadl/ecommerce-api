<?php

namespace Modules\Products\Policies;

use Modules\Users\Models\User;
use Modules\Products\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return $user->can("view_product");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("create_product");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->can("update_product");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->can("delete_product");
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->can("restore_product");
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Product $product): bool
    {
        return $user->can("replicate_product");
    }
}
