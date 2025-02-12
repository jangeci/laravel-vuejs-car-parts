<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\PartController;
use Illuminate\Support\Facades\Route;


Route::get('/cars', [CarController::class, 'index']);
Route::post('/car-create', [CarController::class, 'create']);

Route::prefix('/cars/{carId}')->group(function () {
    Route::get('/', [CarController::class, 'detail']);
    Route::get('/parts', [CarController::class, 'carParts']);
    Route::post('/create', [CarController::class, 'create']);
    Route::post('/update', [CarController::class, 'update']);
    Route::delete('/delete', [CarController::class, 'delete']);
    Route::post('/add-part', [PartController::class, 'create']);
    Route::prefix('parts/{partId}')->group(function () {
        Route::get('/', [PartController::class, 'detail']);
        Route::post('/update', [PartController::class, 'update']);
        Route::delete('/delete', [PartController::class, 'delete']);
    });
});
