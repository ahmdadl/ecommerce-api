<?php

use Illuminate\Support\Facades\Route;
use Modules\ContactUs\Http\Controllers\ContactUsController;
use Modules\ContactUs\Http\Controllers\StoreContactUsMessageController;

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

Route::post("/contact-us", StoreContactUsMessageController::class)
    ->middleware("auth-public")
    ->name("contact-us.store");
