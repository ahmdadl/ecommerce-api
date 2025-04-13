<?php

namespace Modules\Settings\ValueObjects;

class TopHeaderSettings
{
    public function __construct(
        public readonly string $image,
        public readonly string $body,
        public readonly string $end_time,
        public bool $is_active = true
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data["image"] ?? "",
            $data["body"][app()->getLocale()] ?? "",
            $data["end_time"] ?? "",
            (bool) $data["is_active"] ?? false
        );
    }

    public function toArray(): array
    {
        return [
            "name" => $this->image,
            "body" => $this->body,
            "end_time" => $this->end_time,
            "is_active" => $this->is_active,
        ];
    }
}
