<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Carts\Casts\CartTotalsCast;
use Modules\Core\Models\Scopes\HasFiltersScope;
use Modules\Orders\Database\Factories\OrderFactory;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Orders\Enums\OrderStatus;
use Modules\Payments\Interfaces\Payable;
use Modules\Payments\Models\PaymentAttempt;
use Modules\Payments\Models\PaymentMethod;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;

#[UseFactory(OrderFactory::class)]
class Order extends Model implements Payable
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory, HasUlids, HasFiltersScope, SoftDeletes;

    protected function casts(): array
    {
        return [
            "totals" => CartTotalsCast::class,
            "status" => OrderStatus::class,
            "payment_status" => OrderPaymentStatus::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected static function booted(): void
    {
        parent::booted();

        static::created(fn() => forgetLocalizedCache("best-sellers"));
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
     * @return BelongsTo<Customer, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
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
     * @return MorphMany<PaymentAttempt, $this>
     */
    public function paymentAttempts()
    {
        return $this->morphMany(PaymentAttempt::class, "payable");
    }

    /**
     * @return HasMany<OrderItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return HasMany<OrderStatusLog, $this>
     */
    public function statusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    /**
     * {@inheritDoc}
     */
    public function paymentCompleted(): void
    {
        $this->update(["payment_status" => OrderPaymentStatus::PAID]);

        cartService()->destroy();
    }

    /**
     * {@inheritDoc}
     */
    public function paymentFailed(): void
    {
        $this->update(["payment_status" => OrderPaymentStatus::FAILED]);
    }
}
