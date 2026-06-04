<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TutorController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::get('/tutores', [TutorController::class, 'index']);
    Route::get('/tutores/{user}', [TutorController::class, 'show']);
    Route::get('/tutores/{user}/disponibilidad', [TutorController::class, 'availability']);

    Route::apiResource('citas', \App\Http\Controllers\Api\AppointmentController::class);
});

Route::get('/tutores', [TutorController::class, 'index']);
