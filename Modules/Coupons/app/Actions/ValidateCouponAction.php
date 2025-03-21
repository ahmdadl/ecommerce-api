<?php

namespace Modules\Coupons\Actions;

use Modules\Core\Exceptions\ApiException;
use Modules\Core\Traits\HasActionHelpers;
use Modules\Coupons\Models\Coupon;
use Throwable;

class ValidateCouponAction
{
    use HasActionHelpers;

    public function handle(
        mixed $couponOrCode,
        float $totalPrice
    ): true|Throwable {
        /** @var ?Coupon $coupon */
        $coupon = null;

        if ($couponOrCode instanceof Coupon) {
            $coupon = $couponOrCode;
        } elseif (is_string($couponOrCode)) {
            $coupon = Coupon::byCode((string) $couponOrCode)->first();
        }

        if (!$coupon || !$coupon->is_active) {
            throw new ApiException(__("coupons::t.invalid_coupon"));
        }

        $now = now();

        if ($now->lt($coupon->starts_at) || $now->gt($coupon->ends_at)) {
            throw new ApiException(__("coupons::t.coupon_expired"));
        }

        if ($totalPrice < 0) {
            throw new ApiException(__("coupons::t.invalid_total_price"));
        }

        if (!empty($coupon->max_discount)) {
            $discountedPrice = (new CalculateCouponDiscountAction())->handle(
                $coupon,
                $totalPrice
            );

            if ($discountedPrice > $coupon->max_discount) {
                throw new ApiException(__("coupons::t.max_discount_reached"));
            }
        }

        return true;
    }
}
