<?php

use Illuminate\Support\Facades\Route;
use Modules\Guests\Http\Controllers\LoginGuestController;

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

Route::middleware([])->name('guests.')->group(function () {
    Route::post('/login/guests', LoginGuestController::class)->name('login');
});
