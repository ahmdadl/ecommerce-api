<?php

namespace Modules\Users\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\Users\ValueObjects\UserTotals;

class UserTotalCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! json_validate($value)) {
            throw new \Exception('User Totals value is invalid JSON format');
        }

        return UserTotals::fromArray(json_decode($value, true));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! $value instanceof UserTotals) {
            throw new InvalidArgumentException('The provided value is not an instance of UserTotals.');
        }

        return json_encode($value->toArray());
    }
}
