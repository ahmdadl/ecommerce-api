<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Carts\Casts\CartTotalsCast;
use Modules\Core\Models\Scopes\HasFiltersScope;
use Modules\Orders\Database\Factories\OrderFactory;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Orders\Enums\OrderStatus;
use Modules\Payments\Models\PaymentMethod;
use Modules\Users\Models\User;

#[UseFactory(OrderFactory::class)]
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory, HasUlids, HasFiltersScope;

    protected function casts(): array
    {
        return [
            "totals" => CartTotalsCast::class,
            "status" => OrderStatus::class,
            "payment_status" => OrderPaymentStatus::class,
        ];
    }

    /**
     * @return Attribute<PaymentMethod|null, void>
     */
    public function paymentMethodRecord(): Attribute
    {
        return Attribute::make(
            // @phpstan-ignore-next-line
            fn(?string $value, array $attributes) => PaymentMethod::firstWhere(
                "code",
                $attributes["payment_method"]
            )
        )->shouldCache();
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<OrderCoupon, $this>
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(OrderCoupon::class);
    }

    /**
     * @return BelongsTo<OrderAddress, $this>
     */
    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(OrderAddress::class);
    }

    /**
     * @return HasMany<PaymentAttempt, $this>
     */
    public function paymentAttempts(): HasMany
    {
        return $this->hasMany(PaymentAttempt::class);
    }

    /**
     * @return HasMany<OrderItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
