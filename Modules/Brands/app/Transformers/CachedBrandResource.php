<?php

namespace Modules\Brands\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CachedBrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $image = "https://picsum.photos/seed/$this->id/600/600";

        return [
            "id" => $this->id,
            "title" => $this->getTranslations("title"),
            "description" => $this->getTranslations("description"),
            "slug" => $this->slug,
            "image" => $image,
            "meta_title" => $this->getTranslations("meta_title"),
            "meta_description" => $this->getTranslations("meta_description"),
            "meta_keywords" => $this->meta_keywords,
        ];
    }
}
