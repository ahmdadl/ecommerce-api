<?php

namespace Modules\Addresses\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Addresses\Database\Factories\AddressFactory;
use Modules\Cities\Models\City;
use Modules\Governments\Models\Government;
use Modules\Users\Models\User;

#[UseFactory(AddressFactory::class)]
class Address extends Model
{
    /** @use HasFactory<AddressFactory> */
    use HasFactory, HasUlids, SoftDeletes;

    /**
     * casts
     */
    protected function casts(): array
    {
        return [
            "is_default" => "boolean",
        ];
    }

    /**
     * Scope a query to only include users with the specified role.
     *
     * @param  Builder<Address>  $query
     */
    public function scopeDefault(Builder $query, bool $default = true): void
    {
        $query->where("is_default", $default);
    }

    /**
     * @return Attribute<string, void>
     */
    public function name(): Attribute
    {
        return Attribute::make(
            // @phpstan-ignore-next-line
            fn(mixed $value, array $attrs) => $attrs["first_name"] .
                " " .
                $attrs["last_name"]
        );
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
}
