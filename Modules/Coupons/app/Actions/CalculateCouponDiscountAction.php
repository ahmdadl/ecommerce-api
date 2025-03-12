<?php

namespace Modules\Coupons\Actions;

use Modules\Coupons\Enums\CouponDiscountType;
use Modules\Coupons\Models\Coupon;

class CalculateCouponDiscountAction
{
    public function handle(Coupon $coupon, float $totalPrice): float
    {
        if ($totalPrice < 0) {
            // total price is validated in ValidateCouponAction
            return 0;
        }

        $discountedPrice = 0;

        if ($coupon->discount_type == CouponDiscountType::FIXED) {
            $discountedPrice = $coupon->value;
        }

        if ($coupon->discount_type == CouponDiscountType::PERCENTAGE) {
            $discountedPrice = ($totalPrice * $coupon->value) / 100;
        }

        return round($discountedPrice, 2);
    }
}
