<?php

namespace Modules\Banners\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Banners\Database\Factories\BannerFactory;
use Modules\Banners\Enums\BannerActionType;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasSortOrderAttribute;
use Modules\Uploads\Casts\UploadablePathCast;
use Spatie\Translatable\HasTranslations;

#[UseFactory(BannerFactory::class)]
class Banner extends Model
{
    /** @use HasFactory<BannerFactory> */
    use HasFactory,
        HasActiveState,
        HasSortOrderAttribute,
        HasTranslations,
        HasUlids;

    protected array $translatable = ["title", "subtitle"];

    /**
     * cast attrs
     */
    protected function casts(): array
    {
        return [
            "action" => BannerActionType::class,
            "media" => UploadablePathCast::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected static function booted(): void
    {
        parent::booted();

        static::saved(callback: fn() => forgetLocalizedCache("banners"));
    }

    /**
     * actionable type
     *
     * @return MorphTo<Model, $this>
     */
    public function actionable(): MorphTo
    {
        return $this->morphTo();
    }
}
