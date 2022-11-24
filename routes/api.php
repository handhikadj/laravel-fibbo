<?php

use App\Http\Controllers\API\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('fibonacci')->group(function () {
        Route::get('result', [\App\Http\Controllers\API\FibonacciController::class, 'result']);
        Route::post('compute', [\App\Http\Controllers\API\FibonacciController::class, 'compute']);
    });
});
