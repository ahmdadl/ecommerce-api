<?php

namespace Modules\Coupons\Actions;

use Modules\Coupons\Models\Coupon;
use Throwable;

class ValidateCouponAction
{
    public function handle(
        mixed $couponOrCode,
        float $totalPrice
    ): true|Throwable {
        /** @var Coupon $coupon */
        if ($couponOrCode instanceof Coupon) {
            $coupon = $couponOrCode;
        } else {
            $coupon = Coupon::byCode($couponOrCode)->first();
        }

        if (!$coupon || !$coupon?->is_active) {
            throw new \Exception(__("coupons::t.invalid_coupon"));
        }

        $now = now();

        if ($now->lt($coupon->starts_at) || $now->gt($coupon->ends_at)) {
            throw new \Exception(__("coupons::t.coupon_expired"));
        }

        if ($totalPrice < 0) {
            throw new \Exception(__("coupons::t.invalid_total_price"));
        }

        if (!empty($coupon->max_discount)) {
            $discountedPrice = (new CalculateCouponDiscountAction())->handle(
                $coupon,
                $totalPrice
            );

            if ($discountedPrice > $coupon->max_discount) {
                throw new \Exception(__("coupons::t.max_discount_reached"));
            }
        }

        return true;
    }
}
