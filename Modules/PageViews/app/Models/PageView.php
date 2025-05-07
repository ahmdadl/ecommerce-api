<?php

namespace Modules\PageViews\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\PageViews\Casts\UserAgentCast;
use Spatie\Translatable\HasTranslations;
use Modules\PageViews\Database\Factories\PageViewFactory;

#[UseFactory(PageViewFactory::class)]
class PageView extends Model
{
    /** @use HasFactory<PageViewFactory> */
    use HasFactory, HasUlids;

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return [
            "agent" => UserAgentCast::class,
        ];
    }

    /**
     * viewable model
     * @return MorphTo<Model, $this>
     */
    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * viewerable model
     * @return MorphTo<Model, $this>
     */
    public function viewerable(): MorphTo
    {
        return $this->morphTo();
    }
}
