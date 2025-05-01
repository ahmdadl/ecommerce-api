<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\GetHomeController;
use Modules\Core\Http\Controllers\GetInitialDataController;

Route::middleware("auth:guest,customer")->group(function () {
    Route::get("/initial-data", GetInitialDataController::class)->name(
        "user-initial-data"
    );

    Route::get("/home", GetHomeController::class)->name("home");
});
