<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\GetInitialDataController;

Route::middleware("auth:guest,customer")
    ->get("/initial-data", GetInitialDataController::class)
    ->name("user-initial-data");
