<?php

namespace Modules\Coupons\Enums;

use Modules\Core\Traits\HasEnumHelpers;

enum CouponDiscountType: string
{
    use HasEnumHelpers;

    case PERCENTAGE = "percentage";
    case FIXED = "fixed";
}
