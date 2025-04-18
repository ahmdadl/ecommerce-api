<?php

use Illuminate\Support\Facades\Route;
use Modules\Tags\Http\Controllers\GetTagProductsController;
use Modules\Tags\Http\Controllers\TagsController;

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

Route::get("/{activeTag}", GetTagProductsController::class)
    ->name("tags.index")
    ->middleware("auth:guest,customer");
