<?php

namespace Modules\PageMetas\Policies;

use Modules\Users\Models\Admin;
use Modules\PageMetas\Models\PageMeta;
use Illuminate\Auth\Access\HandlesAuthorization;

class PageMetaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can("create_page::meta");
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, PageMeta $pageMeta): bool
    {
        return $admin->can("update_page::meta");
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, PageMeta $pageMeta): bool
    {
        return $admin->can("delete_page::meta");
    }

    /**
     * Determine whether the admin can replicate.
     */
    public function replicate(Admin $admin, PageMeta $pageMeta): bool
    {
        return $admin->can("replicate_page::meta");
    }
}
