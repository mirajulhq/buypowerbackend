<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Settings\App\Http\Controllers\PriceRangeController;
use Modules\Settings\App\Http\Controllers\SuburbController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

// Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//     Route::get('settings', fn (Request $request) => $request->user())->name('settings');
// });
Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('settings', fn (Request $request) => $request->user())->name('settings');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('suburb', SuburbController::class);
    Route::resource('price/range', PriceRangeController::class);
});
