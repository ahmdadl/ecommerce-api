<?php

namespace Modules\Settings\ValueObjects;

class GeneralSettings
{
    public function __construct(
        public readonly string $image,
        public readonly string $body,
        public readonly string $endtime = ""
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data["image"] ?? "",
            $data["body"][app()->getLocale()] ?? "",
            $data["endtime"] ?? ""
        );
    }

    public function toArray(): array
    {
        return [
            "name" => $this->image,
            "description" => $this->body,
            "maintenanceMode" => $this->endtime,
        ];
    }
}
