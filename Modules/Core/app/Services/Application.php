<?php

namespace Modules\Core\Services;

final class Application
{
    /**
     * Admin Application
     * awui >> admin web user interface
     *
     * @const string
     */
    const APP_ADMIN = "awui";

    /**
     * Website Application
     * wui => website user interface
     *
     * @const string
     */
    const APP_WEBSITE = "webOs";

    /**
     * Website Test Application on production database
     * wui => website user interface
     *
     * @const string
     */
    const APP_WEBSITE_TEST = "wuiTest";

    /**
     * Android Application
     *
     * @const string
     */
    const APP_ANDROID = "android";

    /**
     * Ios Application
     *
     * @const string
     */
    const APP_IOS = "ios";

    /**
     * application header to set the value
     */
    const APPLICATION_HEADER = "X-Application-Type";

    /**
     * Current application type
     */
    public static string $currentApplicationType = "";

    /**
     * Set the current application type
     */
    public static function setApplicationType(string $applicationType): void
    {
        self::$currentApplicationType = $applicationType;
    }

    /**
     * Determine if current application is the given one
     */
    public static function is(string $appName): bool
    {
        return self::$currentApplicationType === $appName;
    }

    /**
     * Determine if current application is not the given one
     */
    public static function isNot(string $appName): bool
    {
        return self::$currentApplicationType !== $appName;
    }

    /**
     * Get current application type
     */
    public static function getApplicationType(): string
    {
        return self::$currentApplicationType;
    }

    /**
     * Get application type using os
     */
    public static function getApplicationTypeUsingOS(string $os): string
    {
        /** @var array<string, array<string, string>> $apps */
        $apps = config("auth.apps");

        foreach ($apps as $type => $app) {
            if ($app["os"] === $os) {
                return $type;
            }
        }

        return "";
    }

    /**
     * Check if the ui application in development node
     */
    public static function isUiInDevelopmentMode(): bool
    {
        return request()->header("app-env") === "development";
    }

    /**
     * Get supported applications
     */
    public static function getSupportedApplications(): array
    {
        return [
            // self::APP_ADMIN,
            self::APP_WEBSITE,
            self::APP_WEBSITE_TEST,
            self::APP_ANDROID,
            self::APP_IOS,
        ];
    }
}
