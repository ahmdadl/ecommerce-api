<?php

namespace Modules\Uploads\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<string, string>
 */
class UploadableMultiplePathsCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @param array<string, int> $value
     */
    public function get(
        Model $model,
        string $key,
        mixed $value,
        array $attributes
    ): array {
        return $value ?? [];
        // return !empty($value)
        //     ? array_map(fn($x) => uploads_url($x), $value)
        //     : [];
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
    ): array {
        return $value ?? [];
    }
}
