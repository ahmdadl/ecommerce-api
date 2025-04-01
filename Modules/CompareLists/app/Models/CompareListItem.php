<?php

namespace Modules\CompareLists\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\CompareLists\Database\Factories\CompareListItemFactory;
use Modules\Products\Models\Product;

#[UseFactory(CompareListItemFactory::class)]
class CompareListItem extends Model
{
    /** @use HasFactory<CompareListItemFactory> */
    use HasFactory, HasUlids;

    /**
     * compare list
     * @return BelongsTo<CompareList, $this>
     */
    public function compareList(): BelongsTo
    {
        return $this->belongsTo(CompareList::class);
    }

    /**
     * product
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
