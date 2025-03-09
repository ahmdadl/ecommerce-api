<?php

namespace Modules\Brands\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Brands\Database\Factories\BrandFactory;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasMetaTags;
use Modules\Core\Models\Scopes\HasSortOrderAttribute;
use Modules\Products\Models\Product;
use Spatie\Translatable\HasTranslations;

#[UseFactory(BrandFactory::class)]
class Brand extends Model
{
    use HasFactory,
        HasUlids,
        HasActiveState,
        HasMetaTags,
        HasSortOrderAttribute,
        HasTranslations,
        Sluggable,
        SoftDeletes;

    public $translatable = ["title", "description"];

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "title",
            ],
        ];
    }

    protected function casts(): array
    {
        return ["is_main" => "boolean"];
    }

    /**
     * products relation
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
