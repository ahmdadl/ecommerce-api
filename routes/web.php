<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\Models\Product;
use Modules\Settings\Transformers\SettingResource;

Route::get("/", function () {
    return [
        "Laravel" => app()->version(),
        // "settings" => new SettingResource([]),
    ];
});

require __DIR__ . "/auth.php";
