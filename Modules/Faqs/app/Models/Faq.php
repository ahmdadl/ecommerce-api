<?php

namespace Modules\Faqs\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasSortOrderAttribute;
use Spatie\Translatable\HasTranslations;
use Modules\Faqs\Database\Factories\FaqFactory;

#[UseFactory(FaqFactory::class)]
class Faq extends Model
{
    /** @use HasFactory<FaqFactory> */
    use HasFactory,
        HasUlids,
        HasTranslations,
        HasActiveState,
        HasSortOrderAttribute;

    protected $translatable = ["question", "answer"];

    /**
     * faq category
     * @return BelongsTo<FaqCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FaqCategory::class, "faq_category_id");
    }
}
