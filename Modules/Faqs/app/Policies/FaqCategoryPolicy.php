<?php

namespace Modules\Faqs\Policies;

use Modules\Users\Models\User;
use Modules\Faqs\Models\FaqCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FaqCategory $faqCategory): bool
    {
        return $user->can("view_faq::category");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("create_faq::category");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FaqCategory $faqCategory): bool
    {
        return $user->can("update_faq::category");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FaqCategory $faqCategory): bool
    {
        return $user->can("delete_faq::category");
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, FaqCategory $faqCategory): bool
    {
        return $user->can("restore_faq::category");
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can("reorder_faq::category");
    }
}
