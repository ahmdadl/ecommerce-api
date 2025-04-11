<?php

namespace Modules\Payments\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Scopes\HasActiveState;
use Sushi\Sushi;
use Illuminate\Database\Eloquent\Builder;

class PaymentMethod extends Model
{
    use Sushi, HasActiveState;

    public const CASH_ON_DELIVERY = "cod";
    public const FAWRY = "fawry";
    public const INSTAPAY = "instapay";

    protected $hidden = ["is_active"];

    protected array $rows = [
        [
            "code" => "cod",
            "name_en" => "Cash on Delivery",
            "name_ar" => "الدفع عند الاستلام",
            "is_active" => true,
            "require_receipt" => false,
            "is_online" => false,
            "image" => "cash.svg",
        ],
        [
            "code" => "fawry",
            "name_en" => "Pay with Fawry",
            "name_ar" => "الدفع بفورى ",
            "is_active" => false,
            "require_receipt" => true,
            "is_online" => false,
            "image" => "fawry.webp",
        ],
        [
            "code" => "instapay",
            "name_en" => "Pay with Instapay",
            "name_ar" => "الدفع بانستاباى ",
            "is_active" => true,
            "require_receipt" => true,
            "is_online" => false,
            "image" => "instapay.png",
        ],
    ];

    /**
     * scope by code
     * @param Builder<PaymentMethod> $query
     */
    public function scopeCode(Builder $query, string $code): void
    {
        $query->where("code", $code);
    }

    /**
     * scope by is online
     * @param Builder<PaymentMethod> $query
     */
    public function scopeOnline(Builder $query, bool $isOnline = true): void
    {
        $query->where("is_online", $isOnline);
    }

    /**
     * get localized name
     * @return Attribute<string, void>
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->attributes["name_" . app()->getLocale()]
        )->shouldCache();
    }

    /**
     * get image withUrl
     * @return Attribute<string, void>
     */
    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => url("/img/payments/" . $this->attributes["image"])
        )->shouldCache();
    }

    /**
     * @return Attribute<bool, void>
     */
    public function isCashOnDelivery(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->code === "cod"
        )->shouldCache();
    }

    /**
     * @return Attribute<bool, void>
     */
    public function isFawry(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->code === "fawry"
        )->shouldCache();
    }

    /**
     * @return Attribute<bool, void>
     */
    public function isInstapay(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->code === "instapay"
        )->shouldCache();
    }
}
