<?php

namespace Modules\PageViews\Enums;

use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Products\Models\Product;
use Modules\Tags\Models\Tag;

enum ViewableType: string
{
    use \Modules\Core\Traits\HasEnumHelpers;

    case PRODUCT = "product";
    case CATEGORY = "category";
    case BRAND = "brand";
    case TAG = "tag";
}
