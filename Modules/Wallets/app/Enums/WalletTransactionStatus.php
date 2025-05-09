<?php

namespace Modules\Wallets\Enums;

enum WalletTransactionStatus: string
{
    use \Modules\Core\Traits\HasEnumHelpers;

    case PENDING = "pending";
    case COMPLETED = "completed";
    case CANCELED = "canceled";
}
