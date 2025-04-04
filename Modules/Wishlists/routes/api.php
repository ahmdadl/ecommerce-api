<?php

use Illuminate\Support\Facades\Route;
use Modules\Wishlists\Http\Controllers\WishlistsController;

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

Route::middleware(["auth:guest,customer"])
    ->controller(WishlistsController::class)
    ->name("wishlist.")
    ->prefix("wishlists")
    ->group(function () {
        Route::get("", "index")->name("index");
        Route::post("{product}", "store")->name("store");

        Route::delete("clear", "clear")->name("clear");

        Route::delete("{myWishedProduct}/by-product", "destroyByProduct")->name(
            "destroy-by-product"
        );
        Route::delete("{myWishedItem}", "destroy")->name("destroy");
    });
