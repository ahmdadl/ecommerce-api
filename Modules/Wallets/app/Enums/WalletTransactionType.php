<?php

namespace Modules\Wallets\Enums;

enum WalletTransactionType: string
{
    use \Modules\Core\Traits\HasEnumHelpers;

    case CREDIT = "credit";
    case DEBIT = "debit";
}
