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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Brands\Models\Brand;
use Modules\Carts\Models\CartItem;
use Modules\Categories\Models\Category;
use Modules\CompareLists\Models\CompareListItem;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasMetaTags;
use Modules\Products\Database\Factories\ProductFactory;
use Modules\Products\Filters\ProductFilter;
use Modules\Wishlists\Models\Wishlist;
use Modules\Wishlists\Models\WishlistItem;
use Spatie\Translatable\HasTranslations;

#[UseFactory(ProductFactory::class)]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory,
        HasUlids,
        HasActiveState,
        HasMetaTags,
        HasTranslations,
        Sluggable,
        SoftDeletes;

    /**
     * translatable fields
     *
     * @var array<int, string>
     */
    public array $translatable = ["title", "description"];

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
            if (empty($product->salePrice) || $product->salePrice <= 0) {
                $product->salePrice = $product->price;
            }
        });
    }

    /**
     * product with discount
     * @param  Builder<Product>  $query
     */
    public function scopeHasDiscount(Builder $query): void
    {
        $query
            ->whereNotNull("salePrice")
            ->whereColumn("salePrice", "<", "price");
    }

    /**
     * filter products
     * @param  Builder<Product>  $query
     * @param  ProductFilter  $filter
     * @return Builder<Product>
     */
    public function scopeFilter(Builder $query, ProductFilter $filter): Builder
    {
        return $filter->apply($query);
    }

    /**
     * product has discount
     *
     * @return Attribute<float, void>
     */
    public function isDiscounted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->salePrice < $this->price
        )->shouldCache();
    }

    /**
     * product discounted price
     *
     * @return Attribute<float, void>
     */
    public function discountedPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->salePrice < $this->price
                ? round($this->price - $this->salePrice, 2)
                : 0.0
        )->shouldCache();
    }

    /**
     * product has stock
     *
     * @return Attribute<int, void>
     */
    public function hasStock(): Attribute
    {
        return Attribute::make(get: fn() => $this->stock > 0);
    }

    /**
     * product discounted percentage
     *
     * @return Attribute<float, void>
     */
    public function discountedPercentage(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->salePrice < $this->price
                ? round(
                    (($this->price - $this->salePrice) / $this->price) * 100
                )
                : 0.0
        )->shouldCache();
    }

    /**
     * check if product is wished by current user
     *
     * @return Attribute<bool, void>
     */
    public function isWished(): Attribute
    {
        return Attribute::make(
            get: fn() => user()
                ? user()
                    ->wishlistItems()
                    ->where("product_id", $this->id)
                    ->exists()
                : false
        )->shouldCache();
    }

    /** Relations */

    /**
     * parent category
     *
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * parent brand
     *
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(related: Brand::class);
    }

    /**
     * product cart items
     * @return HasMany<CartItem, $this>
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * product wishlist items
     * @return HasMany<WishlistItem, $this>
     */
    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    /**
     * product compare items
     * @return HasMany<CompareListItem, $this>
     */
    public function compareItems(): HasMany
    {
        return $this->hasMany(CompareListItem::class);
    }
}
