<?php

namespace Modules\Carts\Actions;

use Modules\Carts\Services\CartService;
use Modules\Coupons\Actions\ValidateCouponAction;
use Modules\Coupons\Models\Coupon;

final class ApplyCartCouponAction
{
    public function __construct(public readonly CartService $cartService) {}

    public function handle(Coupon $coupon): void
    {
        $totalPrice = $this->cartService->cart->totals->total;

        (new ValidateCouponAction())->handle($coupon, $totalPrice);

        $this->cartService->applyCoupon($coupon);
    }
}
