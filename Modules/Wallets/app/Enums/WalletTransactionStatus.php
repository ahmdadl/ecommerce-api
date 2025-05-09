<?php

namespace Modules\Wallets\Enums;

enum WalletTransactionStatus: string
{
    use \Modules\Core\Traits\HasEnumHelpers;

    case PENDING = "pending";
    case COMPLETED = "completed";
    case CANCELED = "canceled";

    /**
     * get status color
     */
    public function color(): string
    {
        return match ($this) {
            self::PENDING => "warning",
            self::COMPLETED => "success",
            self::CANCELED => "danger",
        };
    }
}
