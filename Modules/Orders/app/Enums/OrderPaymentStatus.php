<?php

namespace Modules\Orders\Enums;

enum OrderPaymentStatus: string
{
    use \Modules\Core\Traits\HasEnumHelpers;

    case PENDING = "pending";
    case PAID = "paid";
    case FAILED = "failed";
    case CANCELLED = "cancelled";
    case EXPIRED = "expired";

    /**
     * get status color
     */
    public function color(): string
    {
        return match ($this) {
            self::PENDING => "warning",
            self::PAID => "success",
            self::FAILED => "danger",
            self::CANCELLED => "danger",
            self::EXPIRED => "gray",
        };
    }

    /**
     * get localized name
     */
    public function localized(): string
    {
        return __("orders::t.payment_status.{$this->value}");
    }
}
