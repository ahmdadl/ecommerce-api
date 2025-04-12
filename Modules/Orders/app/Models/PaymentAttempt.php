<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Orders\Database\Factories\PaymentAttemptFactory;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Uploads\Casts\UploadablePathCast;

#[UseFactory(PaymentAttemptFactory::class)]
class PaymentAttempt extends Model
{
    /** @use HasFactory<PaymentAttemptFactory> */
    use HasFactory, HasUlids;

    protected function casts(): array
    {
        return [
            "status" => OrderPaymentStatus::class,
            "receipt" => UploadablePathCast::class,
            "payment_details" => "array",
        ];
    }

    /**
     * @return BelongsTo<Order, $this>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function updateToSuccess(): void
    {
        $this->update(["status" => OrderPaymentStatus::PAID]);

        $this->order()->update(["payment_status" => OrderPaymentStatus::PAID]);
    }

    public function updateToFailed(): void
    {
        $this->update(["status" => OrderPaymentStatus::FAILED]);

        $this->order()->update([
            "payment_status" => OrderPaymentStatus::FAILED,
        ]);
    }
}
