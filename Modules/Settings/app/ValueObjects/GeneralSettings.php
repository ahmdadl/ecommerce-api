<?php

namespace Modules\Settings\ValueObjects;

class GeneralSettings
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly bool $maintenanceMode = false
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data["name"] ?? "Application Name",
            description: $data["description"] ?? "",
            maintenanceMode: (bool) $data["maintenance_mode"] ?? false
        );
    }

    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "description" => $this->description,
            "maintenanceMode" => (bool) $this->maintenanceMode,
        ];
    }
}
