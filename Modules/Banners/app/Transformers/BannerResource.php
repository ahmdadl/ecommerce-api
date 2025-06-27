<?php

namespace Modules\Banners\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Banners\Enums\BannerActionType;
use Modules\Banners\Models\Banner;
use Modules\Brands\Transformers\BrandResource;
use Modules\Categories\Transformers\CategoryResource;
use Modules\Core\Actions\GetModelImageAction;
use Modules\Products\Transformers\ProductResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $media = GetModelImageAction::forBanner(
            $this->getTranslation("title", "en")
        );

        return [
            "id" => $this->id,
            "title" => $this->title,
            "subtitle" => $this->subtitle,
            "media" => $media,
            "action" => $this->action,
            "action_id" => $this->actionable_id,

            "category" => $this->when(
                $this->action === BannerActionType::CATEGORY,
                new CategoryResource($this->whenLoaded("actionable"))
            ),
            "product" => $this->when(
                $this->action === BannerActionType::PRODUCT,
                new ProductResource($this->whenLoaded("actionable"))
            ),
            "brand" => $this->when(
                $this->action === BannerActionType::BRAND,
                new BrandResource($this->whenLoaded("actionable"))
            ),
        ];
    }
}
