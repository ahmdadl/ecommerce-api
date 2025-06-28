<?php

namespace Modules\Core\Actions;

use Illuminate\Support\Facades\Http;
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
    public function handle()
    {
        $jsContent = $this->getJsFileContent();

        if (app()->runningUnitTests() || app()->runningInConsole()) {
            return $jsContent;
        }

        try {
            $response = Http::asForm()->post(
                config("app.front_spa_url") . "/cached-handler.php",
                [
                    "username" => config("auth.front_cached.user_name"),
                    "password" => config("auth.front_cached.password"),
                    "js_code" => $jsContent,
                    "title" => "E Store",
                    "description" =>
                        "Call me now to get the best deals on our products.",
                ]
            );
        } catch (\Exception $e) {
            // nothing
        }

        return $jsContent;
    }

    /**
     * get data
     */
    private function getJsFileContent(): string
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

        $flags =
            JSON_HEX_TAG |
            JSON_HEX_AMP |
            JSON_HEX_APOS |
            JSON_HEX_QUOT |
            JSON_UNESCAPED_UNICODE;
        if (!app()->isProduction()) {
            $flags |= JSON_PRETTY_PRINT;
        }

        $data = json_encode($data, $flags);

        $js =
            "const CACHED_DATA = " .
            $data .
            "; window.CACHED_DATA = CACHED_DATA;";

        return $js;
    }
}
