<?php

namespace Modules\Coupons\Utils;

use Modules\Coupons\Actions\CalculateCouponDiscountAction;
use Modules\Coupons\Actions\ValidateCouponAction;
use Modules\Coupons\Models\Coupon;
use Throwable;

final class CouponUtils
{
    /**
     * validate coupon
     */
    public static function validateCoupon(
        Coupon $coupon,
        float $totalPrice
    ): bool|Throwable {
        return (new ValidateCouponAction())->handle($coupon, $totalPrice);
    }

    /**
     * calculate coupon discount
     */
    public static function calculateCouponDiscount(
        Coupon $coupon,
        float $totalPrice
    ): float {
        return (new CalculateCouponDiscountAction())->handle(
            $coupon,
            $totalPrice
        );
    }
}
