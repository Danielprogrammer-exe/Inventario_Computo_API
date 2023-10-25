<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\MaintenanceController;
use App\Http\Controllers\admin\DevicesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'Register']);

Route::post('/login', [AuthController::class, 'login']);
Route::get('/devices/{code}',[DevicesController::class,'show']);

//APIS QUE VAN A NECESITAR VALIDACION
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        // Su lógica aquí
    });

    Route::post('/logout', [AuthController::class, 'Logout']);
    Route::post('/store-maintenance', [MaintenanceController::class, 'store']);
});
