<?php

namespace Modules\PageMetas\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CachedPageMetaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $image = "https://picsum.photos/seed/$this->page_url/150/150";

        return [
            "id" => $this->id,
            "page_url" => $this->page_url,
            "title" => $this->getTranslations("title"),
            "description" => $this->getTranslations("description"),
            "keywords" => $this->keywords,
            "image" => $image,
        ];
    }
}
