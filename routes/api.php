<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|-------------------------------------------
| API Routes
|-------------------------------------------
| Routes for managing availability and reservations
*/

Route::middleware('auth:sanctum')->group(function () {
    // Availability Management
    Route::get('/availability/{room_id}', [\App\Http\Controllers\AvailabilityController::class, 'index']);
    Route::post('/availability/{room_id}', [\App\Http\Controllers\AvailabilityController::class, 'store']);
    Route::put('/availability/{room_id}', [\App\Http\Controllers\AvailabilityController::class, 'update']);

    // Reservation Management
    Route::put('/reservations/{reservation_id}/{action}', [\App\Http\Controllers\ReservationController::class, 'updateStatus']);
});