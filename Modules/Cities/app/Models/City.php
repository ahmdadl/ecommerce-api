<?php

namespace Modules\Cities\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Modules\Cities\Database\Factories\CityFactory;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Governments\Models\Government;

#[UseFactory(CityFactory::class)]
class City extends Model
{
    /** @use HasFactory<CityFactory> */
    use HasFactory, HasUlids, HasTranslations, HasActiveState, SoftDeletes;

    protected array $translatable = ["title"];

    /**
     * city government
     * @return BelongsTo<Government, $this>
     */
    public function government(): BelongsTo
    {
        return $this->belongsTo(Government::class);
    }
}
