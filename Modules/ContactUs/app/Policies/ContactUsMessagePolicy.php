<?php

namespace Modules\ContactUs\Policies;

use Modules\Users\Models\User;
use Modules\ContactUs\Models\ContactUsMessage;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactUsMessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContactUsMessage $contactUsMessage): bool
    {
        return $user->can("delete_contact::us::message");
    }

    /**
     * Determine whether the user can reply models.
     */
    public function reply(User $user): bool
    {
        return $user->can("reply_contact::us::message");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContactUsMessage $contactUsMessage): bool
    {
        return $user->can("delete_contact::us::message");
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(
        User $user,
        ContactUsMessage $contactUsMessage
    ): bool {
        return $user->can("restore_contact::us::message");
    }
}
