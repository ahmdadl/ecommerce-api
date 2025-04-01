<?php

namespace Modules\CompareLists\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\CompareLists\Database\Factories\CompareListFactory;
use Modules\Users\Models\User;

#[UseFactory(CompareListFactory::class)]
class CompareList extends Model
{
    /** @use HasFactory<CompareListFactory> */
    use HasFactory, HasUlids;

    /**
     * compare list owner
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * compare list items
     * @return HasMany<CompareListItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(CompareListItem::class);
    }
}
