<?php

namespace Modules\Settings\Utils;

use Modules\Settings\Models\Setting;

class SettingUtils
{
    public static function getGroupedSettings(): array
    {
        /** @var array $settings */
        $settings = Setting::getInstance()->data;

        $groups = [
            "general" => \Modules\Settings\ValueObjects\GeneralSettings::class,
            "contact" => \Modules\Settings\ValueObjects\ContactSettings::class,
            "social" => \Modules\Settings\ValueObjects\SocialSettings::class,
        ];

        foreach ($settings as $group => $data) {
            if (isset($groups[$group])) {
                $settings[$group] = $groups[$group]::fromArray($data);
            }
        }

        return $settings;
    }

    /**
     * get cached settings
     */
    public static function getCachedSettings(): array
    {
        $currentLocale = app()->getLocale();

        /** @var array<string> $locales */
        $locales = config("app.supported_locales", []);
        foreach ($locales as $locale) {
            app()->setLocale($locale);
            cache()->rememberForever(
                "settings_$locale",
                fn() => self::getGroupedSettings()
            );
        }

        app()->setLocale($currentLocale);

        /** @var array */
        return cache("settings_" . $currentLocale, []);
    }

    public static function revalidateCachedSettings(): void
    {
        $currentLocale = app()->getLocale();

        /** @var array<string> $locales */
        $locales = config("app.supported_locales", []);
        foreach ($locales as $locale) {
            app()->setLocale($locale);
            cache()->forget("settings_$locale");
            self::getCachedSettings();
        }

        app()->setLocale($currentLocale);
    }
}
