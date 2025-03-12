<?php

namespace Modules\Coupons\Policies;

use Modules\Users\Models\User;
use Modules\Coupons\Models\Coupon;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Coupon $coupon): bool
    {
        return $user->can("view_coupon");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("create_coupon");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Coupon $coupon): bool
    {
        return $user->can("update_coupon");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Coupon $coupon): bool
    {
        return $user->can("delete_coupon");
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Coupon $coupon): bool
    {
        return $user->can("restore_coupon");
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Coupon $coupon): bool
    {
        return $user->can("replicate_coupon");
    }
}
