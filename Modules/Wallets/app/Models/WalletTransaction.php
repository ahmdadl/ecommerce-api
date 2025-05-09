<?php

namespace Modules\Wallets\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Payments\Models\PaymentAttempt;
use Modules\Payments\Interfaces\Payable;
use Modules\Payments\Models\PaymentMethod;
use Modules\Users\Models\Customer;
use Modules\Wallets\Database\Factories\WalletTransactionFactory;
use Modules\Wallets\Enums\WalletTransactionStatus;
use Modules\Wallets\Enums\WalletTransactionType;

#[UseFactory(WalletTransactionFactory::class)]
class WalletTransaction extends Model implements Payable
{
    /** @use HasFactory<WalletTransactionFactory> */
    use HasFactory, HasUlids, SoftDeletes;

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return [
            "amount" => "float",
            "type" => WalletTransactionType::class,
            "status" => WalletTransactionStatus::class,
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
     * @return Attribute<Customer|null, void>
     */
    public function user(): Attribute
    {
        return Attribute::make(fn() => $this->wallet->user)->shouldCache();
    }

    /**
     * wallet
     * @return BelongsTo<Wallet, $this>
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * created by user
     * @return BelongsTo<Customer, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Customer::class, "created_by");
    }

    /**
     * @return MorphMany<PaymentAttempt, $this>
     */
    public function paymentAttempts()
    {
        return $this->morphMany(PaymentAttempt::class, "payable");
    }

    /**
     * payment is completed
     */
    public function paymentCompleted(): void
    {
        $this->update([
            "status" => WalletTransactionStatus::COMPLETED,
            "payment_status" => OrderPaymentStatus::PAID,
        ]);

        $this->wallet->balance = $this->wallet->balance->completePendingCredit(
            $this->amount
        );
        $this->wallet->save();
    }

    /**
     * payment failed
     */
    public function paymentFailed(): void
    {
        $this->update([
            "status" => WalletTransactionStatus::CANCELED,
            "payment_status" => OrderPaymentStatus::FAILED,
        ]);

        $this->wallet->balance = $this->wallet->balance->cancelPendingCredit(
            $this->amount
        );

        $this->wallet->save();
    }
}
