<?php

namespace Modules\PageViews\ValueObjects;

use Jenssegers\Agent\Agent as AgentAgent;
use Jenssegers\Agent\Facades\Agent;

final class UserAgent
{
    public function __construct(
        public readonly ?string $browser,
        public readonly ?string $browserVersion,
        public readonly ?string $platform,
        public readonly ?string $platformVersion,
        public readonly ?string $deviceType,
        public readonly ?string $os,
        public readonly ?string $device,
        public readonly bool $isMobile,
        public readonly bool $isBot,
        public readonly array $languages
    ) {
        //
    }

    /**
     * Create from array of data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            browser: $data["browser"] ?? null,
            browserVersion: $data["browser_version"] ?? null,
            platform: $data["platform"] ?? null,
            platformVersion: $data["platform_version"] ?? null,
            deviceType: $data["device_type"] ?? null,
            os: $data["os"] ?? null,
            device: $data["device"] ?? null,
            isMobile: $data["is_mobile"] ?? false,
            isBot: $data["is_bot"] ?? false,
            languages: $data["languages"] ?? []
        );
    }

    /**
     * Convert to array for JSON serialization
     */
    public function toArray(): array
    {
        return [
            "browser" => $this->browser,
            "browser_version" => $this->browserVersion,
            "platform" => $this->platform,
            "platform_version" => $this->platformVersion,
            "device_type" => $this->deviceType,
            "os" => $this->os,
            "device" => $this->device,
            "is_mobile" => $this->isMobile,
            "is_bot" => $this->isBot,
            "languages" => $this->languages,
        ];
    }

    /**
     * create from user agent
     */
    public static function fromUserAgent(
        string $userAgent,
        array $headers = []
    ): self {
        $agent = new AgentAgent($headers, $userAgent);

        return UserAgent::fromArray([
            "browser" => $agent->browser(),
            "browser_version" => $agent->version($agent->browser()),
            "platform" => $agent->platform(),
            "platform_version" => $agent->version($agent->platform()),
            "device_type" => $agent->isPhone()
                ? "phone"
                : ($agent->isTablet()
                    ? "tablet"
                    : "desktop"),
            "os" => $agent->platform(),
            "device" => $agent->device(),
            "is_mobile" => $agent->isMobile(),
            "is_bot" => $agent->isRobot(),
            "languages" => $agent->languages(),
        ]);
    }

    public function isIphone(): bool
    {
        return $this->device !== null &&
            stripos($this->device, "iPhone") !== false;
    }

    public function isIpad(): bool
    {
        return $this->device !== null &&
            stripos($this->device, "iPad") !== false;
    }

    public function isAndroidOs(): bool
    {
        return $this->os !== null && stripos($this->os, "Android") !== false;
    }

    public function isWindows(): bool
    {
        return $this->os !== null && stripos($this->os, "Windows") !== false;
    }

    public function isMacOsx(): bool
    {
        return $this->os !== null && stripos($this->os, "Mac OS X") !== false;
    }

    public function isLinux(): bool
    {
        return $this->os !== null && stripos($this->os, "Linux") !== false;
    }

    public function isChrome(): bool
    {
        return $this->browser !== null &&
            stripos($this->browser, "Chrome") !== false;
    }

    public function isFirefox(): bool
    {
        return $this->browser !== null &&
            stripos($this->browser, "Firefox") !== false;
    }

    public function isSafari(): bool
    {
        return $this->browser !== null &&
            stripos($this->browser, "Safari") !== false;
    }

    public function isEdge(): bool
    {
        return $this->browser !== null &&
            stripos($this->browser, "Edge") !== false;
    }

    public function isOpera(): bool
    {
        return $this->browser !== null &&
            stripos($this->browser, "Opera") !== false;
    }
}
