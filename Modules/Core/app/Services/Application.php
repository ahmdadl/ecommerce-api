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
    const APP_WEBSITE = "wui";

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
    const APPLICATION_HEADER = 'X-Application-Type';

    /**
     * Current application type
     *
     * @var string
     */
    public static string $currentApplicationType = "";

    /**
     * Set the current application type
     *
     * @param string $applicationType
     * @return void
     */
    public static function setApplicationType(string $applicationType): void
    {
        static::$currentApplicationType = $applicationType;
    }

    /**
     * Determine if current application is the given one
     *
     * @param  string $appName
     * @return bool
     */
    public static function is(string $appName): bool
    {
        return static::$currentApplicationType === $appName;
    }

    /**
     * Determine if current application is not the given one
     *
     * @param  string $appName
     * @return bool
     */
    public static function isNot(string $appName): bool
    {
        return static::$currentApplicationType !== $appName;
    }

    /**
     * Get current application type
     *
     * @return string
     */
    public static function getApplicationType(): string
    {
        return static::$currentApplicationType;
    }

    /**
     * Get application type using os
     * 
     * @param  string $os
     * @return string
     */
    public static function getApplicationTypeUsingOS(string $os): string
    {
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
     *
     * @return bool
     */
    public static function isUiInDevelopmentMode(): bool
    {
        return request()->header("app-env") === "development";
    }
}
