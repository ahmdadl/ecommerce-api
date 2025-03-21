<?php

namespace Modules\Orders\Actions;

use Modules\Core\Traits\HasActionHelpers;
use Modules\Coupons\Actions\ValidateCouponAction;
use Modules\Coupons\Models\Coupon;
use Modules\Orders\Models\OrderCoupon;
use Throwable;

class CreateOrderCouponAction
{
    use HasActionHelpers;

    public function handle(
        Coupon $coupon,
        float $totalPrice
    ): OrderCoupon|Throwable {
        // validate coupon
        ValidateCouponAction::new()->handle($coupon, totalPrice: $totalPrice);

        // create order coupon
        return OrderCoupon::createFromCoupon($coupon);
    }
}
