<?php

namespace Modules\Wallets\Enums;

enum WalletTransactionType: string
{
    use \Modules\Core\Traits\HasEnumHelpers;

    case CREDIT = "credit";
    case DEBIT = "debit";

    public function color(): string
    {
        return match ($this) {
            self::CREDIT => "success",
            self::DEBIT => "danger",
        };
    }
}
