<?php

use Illuminate\Support\Facades\Route;
use Modules\Carts\Http\Controllers\CartController;

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
Route::middleware(["auth:customer,guest"])
    ->controller(CartController::class)
    ->prefix("cart")
    ->name("cart.")
    ->group(function () {
        // address routes
        Route::patch("address/{address}", "setCartAddress")->name(
            "set-address"
        );
        Route::delete("address", "removeCartAddress")->name("remove-address");

        // coupon routes
        Route::patch("coupon/{coupon}", "applyCartCoupon")->name(
            "apply-coupon"
        );
        Route::delete("coupon", "removeCartCoupon")->name("remove-coupon");

        Route::get("", "index")->name("index");
        Route::post("{product}", "add")->name("add");

        Route::patch("{product}/by-product", "updateByProduct")->name(
            "update-by-product"
        );
        Route::patch("{cartItem}", "update")->name("update");

        Route::delete("{product}/by-product", "removeByProduct")->name(
            "remove-by-product"
        );
        Route::delete("{cartItem}", "remove")->name("remove");
    });
