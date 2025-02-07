<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\PartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CarController::class, 'index']);
Route::post('/create', [CarController::class, 'create'])->name('car.create');

Route::prefix('car/{carId}')->group(function () {
    Route::get('/', [CarController::class, 'detail']);
    Route::get('/edit', [CarController::class, 'edit']);
    Route::post('/create', [CarController::class, 'create']);
    Route::post('/update', [CarController::class, 'update']);
    Route::get('/delete', [CarController::class, 'delete']);
    Route::prefix('part/{partId}')->group(function () {
        Route::get('/new', [PartController::class, 'new']);
        Route::get('/edit', [PartController::class, 'edit']);
        Route::post('/create', [PartController::class, 'create']);
        Route::post('/update', [PartController::class, 'update']);
        Route::get('/delete', [PartController::class, 'delete']);
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
