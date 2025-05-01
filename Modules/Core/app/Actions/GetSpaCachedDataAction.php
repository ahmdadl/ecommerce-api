<?php

namespace Modules\Core\Actions;

use Modules\Brands\Models\Brand;
use Modules\Brands\Transformers\CachedBrandResource;
use Modules\Categories\Models\Category;
use Modules\Categories\Transformers\CachedCategoryResource;
use Modules\Core\Traits\HasActionHelpers;
use Modules\PageMetas\Models\PageMeta;
use Modules\PageMetas\Transformers\CachedPageMetaResource;
use Modules\Settings\Models\Setting;

final class GetSpaCachedDataAction
{
    use HasActionHelpers;
    public function handle(): string
    {
        $data = $this->getDate();

        $flags =
            JSON_HEX_TAG |
            JSON_HEX_AMP |
            JSON_HEX_APOS |
            JSON_HEX_QUOT |
            JSON_UNESCAPED_UNICODE;
        if (!app()->isProduction()) {
            $flags |= JSON_PRETTY_PRINT;
        }

        $json = json_encode($data, $flags);

        return "const CACHED_DATA = " .
            $json .
            "; window.CACHED_DATA = CACHED_DATA;";
    }

    /**
     * get data
     */
    private function getDate(): array
    {
        $request = request();
        $request->merge([
            "withUnLocalized" => true,
        ]);

        $data = [];

        $data["categories"] = CachedCategoryResource::collection(
            Category::withCount("products")->active()->get()
        );

        $data["brands"] = CachedBrandResource::collection(
            Brand::withCount("products")->active()->get()
        );

        $data["settings"] = Setting::getInstance()->data;

        $data["pageMetas"] = CachedPageMetaResource::collection(
            PageMeta::all()
        );

        return $data;
    }
}
