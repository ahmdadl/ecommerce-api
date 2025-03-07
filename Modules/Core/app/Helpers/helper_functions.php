<?php

use Modules\Core\Utils\ApiResponse;
use Modules\Users\Models\User;

if (!function_exists("api")) {
    /**
     * api response
     *
     * @return ApiResponse
     */
    function api()
    {
        return app(ApiResponse::class);
    }
}

if (!function_exists("user")) {
    /**
     * get current user
     */
    function user(?string $guard = null): ?User
    {
        return auth()->guard($guard)->user();
    }
}

if (!function_exists("settings")) {
    function settings(string $group = null)
    {
        $settings = Cache::rememberForever(
            "settings",
            fn() => \Modules\Settings\Models\Setting::getInstance()->data
        );

        if ($group === null) {
            return $settings;
        }

        $data = $settings[$group] ?? [];
        return match ($group) {
            "general"
                => \Modules\Settings\ValueObjects\GeneralSettings::fromArray(
                $data
            ),
            "contact"
                => \Modules\Settings\ValueObjects\ContactSettings::fromArray(
                $data
            ),
            "social"
                => \Modules\Settings\ValueObjects\SocialSettings::fromArray(
                $data
            ),
            default => $data,
        };
    }
}
