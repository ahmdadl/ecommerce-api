<?php

use Modules\Settings\Models\Setting;
use Modules\Settings\ValueObjects\GeneralSettings;

test("settings_have_groups", function () {
    $settings = Setting::getInstance();

    // Update general settings
    $generalSettings = new GeneralSettings(
        name: ($name = fake()->name),
        description: ($description = fake()->sentence),
        maintenanceMode: ($maintenanceMode = false)
    );
    $settings->updateGroup("general", [
        "name" => [
            "en" => $name,
        ],
        "description" => [
            "en" => $description,
        ],
        "maintenanceMode" => $maintenanceMode,
    ]);

    // Get the settings instance
    $settings = Setting::getInstance();

    // Get general settings as a value object
    $generalSettings = GeneralSettings::fromArray(
        $settings->getGroup("general")
    );

    expect($generalSettings->name)->toBe($name);
    expect($generalSettings->description)->toBe($description);
    expect($generalSettings->maintenanceMode)->toBe($maintenanceMode);
});

test("settings_have_helper_function", function () {
    $general = settings("general");

    expect($general)->toBeInstanceOf(GeneralSettings::class);
    expect($general->name)->toBe("TechStore");
    expect($general->maintenanceMode)->toBeFalse();
});

test("settings_have_transformer", function () {
    $settings = Setting::getInstance();

    // Update general settings
    $generalSettings = new GeneralSettings(
        name: ($name = fake()->name),
        description: ($description = fake()->sentence),
        maintenanceMode: ($maintenanceMode = false)
    );
    $settings->updateGroup("general", [
        "name" => [
            "en" => $name,
        ],
        "description" => [
            "en" => $description,
        ],
        "maintenanceMode" => $maintenanceMode,
    ]);

    // Transform the settings instance
    $resource = new \Modules\Settings\Transformers\SettingResource($settings);

    // Get the transformed data
    $data = $resource->toArray(request());

    expect($data["general"]->name)->toBe($name);
    expect($data["general"]->description)->toBe($description);
    expect($data["general"]->maintenanceMode)->toBe($maintenanceMode);
});
