<?php

use Illuminate\Support\Facades\Route;
use Modules\Wallets\Http\Controllers\WalletsController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
 */

Route::middleware("auth:customer")
    ->prefix("wallets")
    ->name("wallets.")
    ->controller(WalletsController::class)
    ->group(function () {
        Route::get("", "index")->name("index");
        Route::post("credit", "credit")->name("credit");
    });
