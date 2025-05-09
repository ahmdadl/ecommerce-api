<?php

namespace Modules\Wallets\Policies;

use Modules\Users\Models\Admin;
use Modules\Wallets\Models\WalletTransaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalletTransactionPolicy
{
    use HandlesAuthorization;

    public function change_wallet_transaction_status(
        Admin $admin,
        WalletTransaction $walletTransaction
    ): bool {
        return $admin->can("change_wallet_transaction_status");
    }

    public function view_payment_attempts(
        Admin $admin,
        WalletTransaction $walletTransaction
    ): bool {
        return $admin->can("view_payment_attempts");
    }
}
