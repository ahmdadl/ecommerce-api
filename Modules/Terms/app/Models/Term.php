<?php

namespace Modules\Terms\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasSortOrderAttribute;
use Spatie\Translatable\HasTranslations;

class Term extends Model
{
    /** @use HasFactory<TermFactory> */
    use HasFactory,
        HasUlids,
        HasTranslations,
        HasSortOrderAttribute,
        HasActiveState;

    protected array $translatable = ["title", "content"];
}
