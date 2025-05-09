<?php

namespace Modules\Payments\Enums;

enum PaymentAttemptType: string
{
    use \Modules\Core\Traits\HasEnumHelpers;

    case ORDERS = "orders";
    case WALLET = "wallet";
}
