<?php

use Illuminate\Support\Facades\Route;
use Modules\Orders\Http\Controllers\CreateOrderController;

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

Route::middleware(["auth:customer"])->group(function () {
    Route::post("orders", CreateOrderController::class)->name("orders.store");
});
