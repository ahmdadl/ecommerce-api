<?php

namespace Modules\Coupons\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Coupons\Enums\CouponDiscountType;
use Modules\Coupons\Database\Factories\CouponFactory;

#[UseFactory(CouponFactory::class)]
class Coupon extends Model
{
    /** @use HasFactory<CouponFactory> */
    use HasFactory, HasUlids, HasActiveState, SoftDeletes;

    protected function casts(): array
    {
        return [
            "starts_at" => "date",
            "ends_at" => "date",
            "discount_type" => CouponDiscountType::class,
            "value" => "float",
            "max_discount" => "float",
            "used_count" => "int",
        ];
    }

    /**
     * find coupon by its code
     *
     * @param  Builder<Coupon>  $query
     */
    public function scopeByCode(Builder $query, string $code): void
    {
        $query->where("code", $code);
    }
}
