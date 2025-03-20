<?php

namespace Modules\Carts\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Addresses\Models\Address;
use Modules\Carts\Casts\CartTotalsCast;
use Modules\Carts\Database\Factories\CartFactory;
use Modules\Coupons\Models\Coupon;
use Modules\Orders\Models\Order;

#[UseFactory(CartFactory::class)]
class Cart extends Model
{
    /** @use HasFactory<CartFactory> */
    use HasFactory, HasUlids;

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return [
            "totals" => CartTotalsCast::class,
        ];
    }

    /**
     * cart owner
     * @return MorphTo<Model, $this>
     */
    public function cartable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * cart items
     * @return HasMany<CartItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * coupon
     * @return BelongsTo<Coupon, $this>
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * address
     * @return BelongsTo<Address, $this>
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * @return BelongsTo<Order, $this>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
