<?php

namespace Modules\Categories\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Categories\Database\Factories\CategoryFactory;
use Modules\Core\Events\CachedSpaDataUpdated;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasMetaTags;
use Modules\Core\Models\Scopes\HasSortOrderAttribute;
use Modules\Core\Observers\CachedSpaDataUpdatedObserver;
use Modules\Products\Models\Product;
use Modules\Uploads\Casts\UploadablePathCast;
use Spatie\Translatable\HasTranslations;

#[ObservedBy(CachedSpaDataUpdatedObserver::class)]
#[UseFactory(CategoryFactory::class)]
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory,
        HasUlids,
        HasActiveState,
        HasMetaTags,
        HasSortOrderAttribute,
        HasTranslations,
        Sluggable,
        SoftDeletes;

    /**
     * translatable fields
     */
    public array $translatable = ["title", "description"];

    /**
     * get route key name
     */
    public function getRouteKeyName(): string
    {
        return "slug";
    }

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

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return ["is_main" => "boolean", "image" => UploadablePathCast::class];
    }

    /**
     * products relation
     *
     * @return HasMany<Product, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->active();
    }

    /**
     * all products relation
     *
     * @return HasMany<Product, $this>
     */
    public function allProducts(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
