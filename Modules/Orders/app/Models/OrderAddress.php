<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Addresses\Models\Address;
use Modules\Cities\Models\City;
use Modules\Governments\Models\Government;
use Modules\Orders\Database\Factories\OrderAddressFactory;
use Modules\Users\Models\User;
use Spatie\Translatable\HasTranslations;

#[UseFactory(OrderAddressFactory::class)]
class OrderAddress extends Model
{
    /** @use HasFactory<OrderAddressFactory> */
    use HasFactory, HasUlids, HasTranslations;

    protected array $translatable = ["city_name"];

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return [
            "shipping_fees" => "float",
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Government, $this>
     */
    public function government(): BelongsTo
    {
        return $this->belongsTo(Government::class);
    }

    /**
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsTo<Address, $this>
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
