<?php

namespace Modules\Banners\Enums;

use Modules\Core\Traits\HasEnumHelpers;

enum BannerActionType: string
{
    use HasEnumHelpers;

    case CATEGORY = "category";
    case PRODUCT = "product";
    case BRAND = "brand";

    case MEDIA = "media";

    /**
     * badge color
     */
    public function color(): string
    {
        return match ($this) {
            self::CATEGORY => "info",
            self::PRODUCT => "warning",
            self::BRAND => "success",
            self::MEDIA => "primary",
        };
    }
}
