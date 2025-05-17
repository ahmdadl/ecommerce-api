<?php

namespace Modules\Core\Actions;

use Modules\Brands\Models\Brand;
use Modules\Brands\Transformers\CachedBrandResource;
use Modules\Categories\Models\Category;
use Modules\Categories\Transformers\CachedCategoryResource;
use Modules\Governments\Models\Government;
use Modules\Governments\Transformers\CachedGovernmentResource;
use Modules\PageMetas\Models\PageMeta;
use Modules\PageMetas\Transformers\CachedPageMetaResource;
use Modules\Settings\Models\Setting;

class GetSsrCachedDataAction
{
    public function handle(): array
    {
        return $this->getData();
    }

    private function getData(): array
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

        $data["governments"] = CachedGovernmentResource::collection(
            Government::with("cities")->get()
        );

        return $data;
    }
}
