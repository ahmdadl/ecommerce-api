<?php

namespace Modules\Wallets\Enums;

enum WalletType: string
{
    use \Modules\Core\Traits\HasEnumHelpers;

    case CREDIT = "credit";
    case DEBIT = "debit";
}
