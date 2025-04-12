<?php

use Illuminate\Support\Facades\Route;
use Modules\Carts\Http\Controllers\CartsController;
use Modules\Carts\Http\Controllers\OnlinePaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::prefix("/payments/{paymentAttempt}/")
        ->name("payments.")
        ->controller(OnlinePaymentController::class)
        ->group(function () {
            Route::get("", "index")->name("index");
            Route::get("success", "success")->name("success");
            Route::get("after-success", "afterSuccess")->name("afterSuccess");

            Route::get("failed", "failed")->name("failed");
            Route::get("after-failed", "afterFailed")->name("afterFailed");
        });
});
