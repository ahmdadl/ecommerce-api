<?php

use Illuminate\Support\Facades\Route;
use Modules\Faqs\Http\Controllers\FaqsController;
use Modules\Faqs\Http\Controllers\GetFaqsController;

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

Route::get("/faqs", GetFaqsController::class)
    ->middleware("auth-public")
    ->name("faqs.index");
