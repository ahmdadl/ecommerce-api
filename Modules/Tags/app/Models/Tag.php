<?php

namespace Modules\Tags\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasMetaTags;
use Modules\Products\Models\Product;
use Spatie\Translatable\HasTranslations;
use Modules\Tags\Database\Factories\TagFactory;

#[UseFactory(TagFactory::class)]
class Tag extends Model
{
    /** @use HasFactory<TagFactory> */
    use HasFactory,
        HasUlids,
        HasTranslations,
        Sluggable,
        HasActiveState,
        HasMetaTags;

    protected array $translatable = ["title", "description"];

    /**
     * slug source
     */
    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "title",
            ],
        ];
    }

    /**
     * products
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
