<?php

namespace Modules\Settings\ValueObjects;

class SocialSettings
{
    public function __construct(public readonly string $facebook) {}

    public static function fromArray(array $data): self
    {
        return new self(
            facebook: $data["facebook"] ?? "https://www.facebook.com"
        );
    }

    public function toArray(): array
    {
        return [
            "facebook" => $this->facebook,
        ];
    }
}
