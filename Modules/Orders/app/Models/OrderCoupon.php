<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Coupons\Enums\CouponDiscountType;
use Modules\Coupons\Models\Coupon;
use Modules\Orders\Database\Factories\OrderCouponFactory;

#[UseFactory(OrderCouponFactory::class)]
class OrderCoupon extends Model
{
    /** @use HasFactory<OrderCouponFactory> */
    use HasFactory, HasUlids;

    protected function casts(): array
    {
        return [
            "discount_type" => CouponDiscountType::class,
            "value" => "float",
        ];
    }

    /**
     * @return BelongsTo<Coupon, $this>
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
