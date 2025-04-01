<?php

namespace Modules\Wishlists\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Core\Models\Scopes\PaginateIfRequestedScope;
use Modules\Wishlists\Database\Factories\WishlistFactory;

#[UseFactory(WishlistFactory::class)]
class Wishlist extends Model
{
    /** @use HasFactory<WishlistFactory> */
    use HasFactory, HasUlids, PaginateIfRequestedScope;

    /**
     * wishlist owner
     * @return MorphTo<Model, $this>
     */
    public function wishlistable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * wishlist items
     * @return HasMany<WishlistItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }
}
