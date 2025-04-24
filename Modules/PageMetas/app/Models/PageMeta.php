<?php

namespace Modules\PageMetas\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Observers\CachedSpaDataUpdatedObserver;
use Spatie\Translatable\HasTranslations;
use Modules\PageMetas\Database\Factories\PageMetaFactory;
use Modules\Uploads\Casts\UploadablePathCast;

#[ObservedBy(CachedSpaDataUpdatedObserver::class)]
#[UseFactory(PageMetaFactory::class)]
class PageMeta extends Model
{
    /** @use HasFactory<PageMetaFactory> */
    use HasFactory, HasUlids, HasTranslations;

    protected array $translatable = ["title", "description"];

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return [
            "keywords" => "json",
            "image" => UploadablePathCast::class,
        ];
    }
}
