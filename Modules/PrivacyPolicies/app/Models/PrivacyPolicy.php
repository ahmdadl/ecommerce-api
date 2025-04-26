<?php

namespace Modules\PrivacyPolicies\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasSortOrderAttribute;
use Spatie\Translatable\HasTranslations;

class PrivacyPolicy extends Model
{
    /** @use HasFactory<PrivacyPolicyFactory> */
    use HasFactory,
        HasUlids,
        HasTranslations,
        HasActiveState,
        HasSortOrderAttribute;

    protected array $translatable = ["title", "content"];
}
