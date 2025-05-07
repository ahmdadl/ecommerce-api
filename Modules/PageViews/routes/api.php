<?php

use Illuminate\Support\Facades\Route;
use Modules\PageViews\Http\Controllers\CreatePageViewController;
use Modules\PageViews\Http\Controllers\PageViewsController;

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

Route::post("/page-views", CreatePageViewController::class)
    ->name("page-views")
    ->middleware(["auth:guest,customer", "throttle:5,1"]);
