<?php

namespace Modules\Governments\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Governments\Database\Factories\GovernmentFactory;
use Spatie\Translatable\HasTranslations;

#[UseFactory(GovernmentFactory::class)]
class Government extends Model
{
    /** @use HasFactory<GovernmentFactory> */
    use HasFactory, HasUlids, HasActiveState, HasTranslations, SoftDeletes;

    /**
     * translatable fields
     */
    public array $translatable = ["title"];

    protected function casts(): array
    {
        return [
            "shippingFees" => "float",
        ];
    }
}
