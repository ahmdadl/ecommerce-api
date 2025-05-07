<?php

namespace Modules\PageViews\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\PageViews\ValueObjects\UserAgent;

class UserAgentCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(
        Model $model,
        string $key,
        mixed $value,
        array $attributes
    ): ?UserAgent {
        // @phpstan-ignore-next-line
        if (!json_validate($value)) {
            throw new \Exception("User Agent value is invalid JSON format");
        }

        // @phpstan-ignore-next-line
        return UserAgent::fromArray(json_decode($value, true));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(
        Model $model,
        string $key,
        mixed $value,
        array $attributes
    ): ?string {
        if (!$value instanceof UserAgent) {
            throw new InvalidArgumentException(
                "The provided value is not an instance of CartTotals."
            );
        }

        // @phpstan-ignore-next-line
        return json_encode($value->toArray());
    }
}
