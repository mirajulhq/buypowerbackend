<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\GeocodingController;
use Modules\User\App\Http\Controllers\UserController;

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
//     Route::get('user', fn (Request $request) => $request->user())->name('user');
// });
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('user', UserController::class);
    Route::post('/user/survey/{profile_id}', [Modules\User\App\Http\Controllers\UserController::class, 'storeSurvey']);
});
Route::get('/get-region-info/{latitude}/{longitude}', [GeocodingController::class, 'getRegionInfo']);
