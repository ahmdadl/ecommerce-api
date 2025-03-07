<?php

namespace Modules\Settings\ValueObjects;

class ContactSettings
{
    public function __construct(
        public readonly string $email,
        public readonly array $phoneNumbers = [],
        public readonly string $address,
        public readonly string $googleMapUrl
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data["email"] ?? "contact@example.com",
            phoneNumbers: $data["phoneNumbers"] ?? [],
            address: $data["address"] ?? "",
            googleMapUrl: $data["googleMapUrl"] ?? ""
        );
    }

    public function toArray(): array
    {
        return [
            "email" => $this->email,
            "phoneNumbers" => $this->phoneNumbers,
            "address" => $this->address,
            "googleMapUrl" => $this->googleMapUrl,
        ];
    }
}
