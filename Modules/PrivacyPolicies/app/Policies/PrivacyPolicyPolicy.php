<?php

namespace Modules\PrivacyPolicies\Policies;

use Modules\Users\Models\Admin;
use Modules\PrivacyPolicies\Models\PrivacyPolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrivacyPolicyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can("create_privacy::policy");
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, PrivacyPolicy $privacyPolicy): bool
    {
        return $admin->can("update_privacy::policy");
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, PrivacyPolicy $privacyPolicy): bool
    {
        return $admin->can("delete_privacy::policy");
    }

    /**
     * Determine whether the admin can replicate.
     */
    public function replicate(Admin $admin, PrivacyPolicy $privacyPolicy): bool
    {
        return $admin->can("replicate_privacy::policy");
    }
}
