<?php

namespace Modules\Products\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasMetaTags;
use Modules\Products\Database\Factories\ProductFactory;
use Spatie\Translatable\HasTranslations;

#[UseFactory(ProductFactory::class)]
class Product extends Model
{
    use HasFactory,
        HasUlids,
        HasActiveState,
        HasMetaTags,
        HasTranslations,
        Sluggable,
        SoftDeletes;

    /**
     * translatable fields
     */
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

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return [
            "is_main" => "boolean",
            "price" => "float",
            "salePrice" => "float",
            "images" => "array",
        ];
    }

    /**
     * boot model
     */
    public static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product) {
            if (empty($product->salePrice)) {
                $product->salePrice = $product->price;
            }
        });
    }

    /**
     * product with discount
     */
    public function scopeHasDiscount(Builder $query): void
    {
        $query
            ->whereNotNull("salePrice")
            ->whereColumn("salePrice", "<", "price");
    }

    /**
     * product has discount
     */
    public function isDiscounted(): Attribute
    {
        return Attribute::make(get: fn() => $this->salePrice < $this->price);
    }

    /**
     * product discounted price
     */
    public function discountedPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->salePrice < $this->price
                ? round($this->price - $this->salePrice, 2)
                : 0.0
        );
    }

    /** Relations */

    /**
     * parent category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * parent brand
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
