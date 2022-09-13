<?php

use App\Http\Controllers\GetAvailableDaysForSpecialistController;
use App\Http\Controllers\GetAvailableHoursInSpecialistDayController;
use App\Http\Controllers\GetSpecialistListController;
use App\Http\Controllers\GetSpecialityListController;
use Illuminate\Support\Facades\Route;

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

Route::as('api.')->group(function (): void {
    Route::get('/specialities', GetSpecialityListController::class)->name('specialities.index');
    Route::prefix('specialists')->as('specialists.')->group(function (): void {
        Route::get('/', GetSpecialistListController::class)->name('index');
        Route::prefix('{specialist}')->as('days.')->group(function (): void {
            Route::get('/', GetAvailableDaysForSpecialistController::class)->name('index');
            Route::get('{day}', GetAvailableHoursInSpecialistDayController::class)->name('hours.index');
        });
    });
});
