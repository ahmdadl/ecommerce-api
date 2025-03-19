<?php

namespace Modules\Payments\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Scopes\HasActiveState;
use Sushi\Sushi;

class PaymentMethod extends Model
{
    use Sushi, HasActiveState;

    protected array $appends = ["name"];

    protected array $hidden = ["localizedName", "is_active"];

    protected array $rows = [
        [
            "code" => "cod",
            "localizedName" => [
                "en" => "Cash on Delivery",
                "ar" => "الدفع عند الاستلام",
            ],
            "is_active" => true,
        ],
        [
            "code" => "fawry",
            "localizedName" => [
                "en" => "Pay with Fawry",
                "ar" => "الدفع Fawry ",
            ],
            "is_active" => true,
        ],
    ];

    /**
     * get localized name
     * @return Attribute<string, void>
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->localizedName[app()->getLocale()]
        );
    }
}
