<?php

use Illuminate\Support\Facades\Route;
use Modules\CompareLists\Http\Controllers\CompareListsController;

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

Route::middleware(["auth:customer"])
    ->controller(CompareListsController::class)
    ->name("compare-list.")
    ->prefix("compare-lists")
    ->group(function () {
        Route::get("", "index")->name("index");
        Route::post("{product}", "store")->name("store");
        Route::delete("{myCompareItem}", "destroy")->name("destroy");
        Route::delete("", "clear")->name("clear");
    });
