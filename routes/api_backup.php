<?php

use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|-------------------------------------------
| API Routes
|-------------------------------------------
| Routes for managing availability and reservations
*/

Route::apiResource('/reservations', ReservationController::class);

// Route::prefix('v1')->group(function () {
//     // Availability
//     Route::get('/availability/{room_id}', [AvailabilityController::class, 'show']);
//     Route::post('/availability/{room_id}', [AvailabilityController::class, 'update']);

//     // Reservations
//     Route::get('/reservations', [ReservationController::class, 'index']);
//     Route::get('/reservations/{id}', [ReservationController::class, 'indexDetail']);
//     Route::post('/reservations/{id}/accept', [ReservationController::class, 'accept']);
//     Route::post('/reservations/{id}/reject', [ReservationController::class, 'reject']);
// });
