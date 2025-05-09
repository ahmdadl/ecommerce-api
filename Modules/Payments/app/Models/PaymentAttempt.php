<?php

namespace Modules\Payments\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Orders\Database\Factories\PaymentAttemptFactory;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Payments\Enums\PaymentAttemptType;
use Modules\Payments\Models\PaymentMethod;
use Modules\Uploads\Casts\UploadablePathCast;

#[UseFactory(PaymentAttemptFactory::class)]
class PaymentAttempt extends Model
{
    /** @use HasFactory<PaymentAttemptFactory> */
    use HasFactory, HasUlids, SoftDeletes;

    protected function casts(): array
    {
        return [
            "status" => OrderPaymentStatus::class,
            "receipt" => UploadablePathCast::class,
            "payment_details" => "array",
            "type" => PaymentAttemptType::class,
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
     * attempt owner
     * @return MorphTo<Model, $this>
     */
    public function payable()
    {
        return $this->morphTo();
    }

    /**
     * update payment attempt to success
     */
    public function updateToSuccess(): void
    {
        $this->update(["status" => OrderPaymentStatus::PAID]);

        $this->payable->paymentCompleted();
    }

    /**
     * payment attempt failed
     */
    public function updateToFailed(): void
    {
        $this->update(["status" => OrderPaymentStatus::FAILED]);

        $this->payable->paymentFailed();
    }
}
