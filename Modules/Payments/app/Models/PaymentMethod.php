<?php

namespace Modules\Payments\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Scopes\HasActiveState;
use Sushi\Sushi;

class PaymentMethod extends Model
{
    use Sushi, HasActiveState;

    protected $appends = ["name"];

    protected $hidden = ["localizedName", "is_active"];

    protected array $rows = [
        [
            "code" => "cod",
            "name_en" => "Cash on Delivery",
            "name_ar" => "الدفع عند الاستلام",
            "is_active" => true,
        ],
        [
            "code" => "fawry",
            "name_en" => "Pay with Fawry",
            "name_ar" => "الدفع Fawry ",
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
            get: fn() => $this->attributes["name_" . app()->getLocale()]
        );
    }
}
