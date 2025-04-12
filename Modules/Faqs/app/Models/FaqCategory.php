<?php

namespace Modules\Faqs\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasSortOrderAttribute;
use Spatie\Translatable\HasTranslations;
use Modules\Faqs\Database\Factories\FaqCategoryFactory;

#[UseFactory(FaqCategoryFactory::class)]
class FaqCategory extends Model
{
    /** @use HasFactory<FaqCategoryFactory> */
    use HasFactory,
        HasUlids,
        HasTranslations,
        HasActiveState,
        HasSortOrderAttribute;

    protected array $translatable = ["title"];

    /**
     * faqs
     * @return HasMany<Faq, $this>
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class);
    }
}
