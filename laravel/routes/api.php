<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\StationController;
use App\Http\Controllers\Api\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum','admin'])->group(function () {
    Route::post('/station', [StationController::class, 'store']);
    Route::patch('/station/{id}', [StationController::class, 'update']);
    Route::delete('/station/{id}', [StationController::class, 'destroy']);
    Route::get('/admin/statistics', [StatisticsController::class,'index']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/stations', [StationController::class, 'search']);
    Route::post('/book', [ReservationController::class, 'book']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);
    Route::patch('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);
    Route::get('/history', [ReservationController::class, 'history']);

});

?>