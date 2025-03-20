<?php

namespace Modules\Orders\Enums;

enum OrderPaymentStatus: string
{
    use \Modules\Core\Traits\HasEnumHelpers;

    case PENDING = "pending";
    case PAID = "paid";
    case CANCELLED = "cancelled";
    case EXPIRED = "expired";
}
