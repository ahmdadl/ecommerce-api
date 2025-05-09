<?php

namespace Modules\Wallets\Actions;

use Modules\Core\Traits\HasActionHelpers;
use Modules\Wallets\Models\Wallet;
use Modules\Wallets\Models\WalletTransaction;
use Modules\Wallets\Transformers\WalletResource;

class GetWalletAction
{
    use HasActionHelpers;

    public function handle(): WalletResource
    {
        $wallet = walletService()->wallet;

        $wallet->loadMissing([
            "transactions" => fn($q) => $q->latest()->limit(10),
        ]);

        return new WalletResource($wallet);
    }
}
