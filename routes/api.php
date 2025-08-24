<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CarModelController;
use App\Http\Controllers\Api\CarController;

Route::post('/login',  [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/brands', [BrandController::class, 'index']);
Route::get('/models', [CarModelController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('cars', CarController::class);
});
