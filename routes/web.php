<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\Database\Seeders\ProductsDatabaseSeeder;

Route::get("/", function () {
    (new ProductsDatabaseSeeder())->run();

    return [
        "Laravel" => app()->version(),
        // "settings" => new SettingResource([]),
    ];
});

require __DIR__ . "/auth.php";
