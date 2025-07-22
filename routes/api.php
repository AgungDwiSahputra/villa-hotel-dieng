<?php

use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
// });
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // Availability
    Route::get('/products', [ProductController::class, 'getAllProduct']);
    Route::get('/products/{id}', [ProductController::class, 'getProductById']);
    Route::get('/availability/{produk_id}', [AvailabilityController::class, 'show']);
    Route::post('/availability/{produk_id}', [AvailabilityController::class, 'store']);
    Route::put('/availability/{produk_id}/{id}', [AvailabilityController::class, 'update']);
    Route::delete('/availability/{produk_id}/{id}', [AvailabilityController::class, 'destroy']);

    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/{id}', [ReservationController::class, 'indexDetail']);
    Route::get('/reservations/by-date/{date}', [ReservationController::class, 'reservationByDate']);
    Route::post('/reservations/{transaksi_id}/acceptAll', [ReservationController::class, 'acceptAll']);
    Route::post('/reservations/{id}/accept', [ReservationController::class, 'accept']);
    Route::post('/reservations/{id}/reject', [ReservationController::class, 'reject']);
});