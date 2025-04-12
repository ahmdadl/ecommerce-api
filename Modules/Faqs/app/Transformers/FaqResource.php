<?php

namespace Modules\Faqs\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "category_id" => $this->faq_category_id,
            "question" => $this->question,
            "answer" => $this->answer,
        ];
    }
}
