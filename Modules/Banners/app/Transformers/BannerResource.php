<?php

namespace Modules\Banners\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $media = $this->media;
        if (empty($media)) {
            $media = "https://picsum.photos/seed/{$this->id}/1920/1080";
        }

        return [
            "id" => $this->id,
            "title" => $this->title,
            "subtitle" => $this->subtitle,
            "media" => $media,
            "action" => $this->action,
            "action_id" => $this->actionable_id,
        ];
    }
}
