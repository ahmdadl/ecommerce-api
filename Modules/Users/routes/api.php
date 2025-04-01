<?php

use Illuminate\Support\Facades\Route;
use Modules\Addresses\Http\Controllers\AddressesController;
use Modules\Orders\Http\Controllers\OrdersController;
use Modules\Users\Http\Controllers\AuthUserController;
use Modules\Users\Http\Controllers\UserProfileController;
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

Route::middleware(["auth:guest"])
    ->controller(AuthUserController::class)
    ->name("auth.")
    ->group(function () {
        Route::post("login", "login")->name("login");
        Route::post("register", "register")->name("register");

        Route::post("forget-password", "forgetPassword")->name(
            "forget-password"
        );
        Route::post("reset-password", "resetPassword")->name("reset-password");
    });

Route::middleware(["auth:customer"])
    ->name("profile.")
    ->prefix("profile")
    ->group(function () {
        Route::controller(UserProfileController::class)->group(function () {
            Route::post("update", "updateProfile")->name("updateProfile");
            Route::post("change-password", "updatePassword")->name(
                "changePassword"
            );
        });

        Route::get("wishlist", [WishlistsController::class, "index"])->name(
            "wishlist"
        );

        Route::get("orders", [OrdersController::class, "index"])->name(
            "orders"
        );

        Route::get("addresses", [AddressesController::class, "index"])->name(
            "addresses"
        );
    });
