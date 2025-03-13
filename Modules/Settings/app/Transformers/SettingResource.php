<?php

namespace Modules\Settings\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Settings\ValueObjects\ContactSettings;
use Modules\Settings\ValueObjects\GeneralSettings;
use Modules\Settings\ValueObjects\SocialSettings;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        /** @var array $data */
        $data = settings();

        return $data;
    }
}
