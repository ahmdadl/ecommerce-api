<?php

namespace Modules\Wallets\Policies;

use Modules\Users\Models\Admin;
use Modules\Wallets\Models\Wallet;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalletPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can("create_wallet");
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Wallet $wallet): bool
    {
        return $admin->can("update_wallet");
    }

    /**
     * Determine whether the admin can credit the model.
     */
    public function credit(Admin $admin, Wallet $wallet): bool
    {
        return $admin->can("credit_wallet");
    }

    /**
     * Determine whether the admin can debit the model.
     */
    public function debit(Admin $admin, Wallet $wallet): bool
    {
        return $admin->can("debit_wallet");
    }
}
