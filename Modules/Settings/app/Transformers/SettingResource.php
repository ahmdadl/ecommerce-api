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
        // Ensure the resource is the Setting model instance
        if (!$this->resource) {
            return [];
        }

        // Extract the data column
        $data = $this->data ?? [];

        // Transform each group using value objects
        $generalSettings = GeneralSettings::fromArray($data["general"] ?? []);
        $socialSettings = SocialSettings::fromArray($data["social"] ?? []);
        $contactSettings = ContactSettings::fromArray($data["contact"] ?? []);

        return [
            "general" => $generalSettings->toArray(),
            "social" => $socialSettings->toArray(),
            "contact" => $contactSettings->toArray(),
        ];
    }
}
