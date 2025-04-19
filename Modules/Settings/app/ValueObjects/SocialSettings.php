<?php

namespace Modules\Settings\ValueObjects;

class SocialSettings
{
    public function __construct(
        public readonly string $facebook,
        public readonly string $twitter,
        public readonly string $instagram,
        public readonly string $youtube,
        public readonly string $whatsapp,
        public readonly string $linkedin
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data["facebook"] ?? "https://www.facebook.com",
            $data["twitter"] ?? "https://twitter.com",
            $data["instagram"] ?? "https://www.instagram.com",
            $data["youtube"] ?? "https://www.youtube.com",
            $data["whatsapp"] ?? "https://web.whatsapp.com/",
            $data["linkedin"] ?? "https://www.linkedin.com/"
        );
    }

    public function toArray(): array
    {
        return [
            "facebook" => $this->facebook,
            "twitter" => $this->twitter,
            "instagram" => $this->instagram,
            "youtube" => $this->youtube,
            "whatsapp" => $this->whatsapp,
            "linkedin" => $this->linkedin,
        ];
    }
}
