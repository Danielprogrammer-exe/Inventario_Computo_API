<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\MaintenancesController;
use App\Http\Controllers\admin\FixedassetController;
use App\Http\Controllers\admin\DevicesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'Register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('devices/',[DevicesController::class,'index']);
Route::get('devices/{id}',[DevicesController::class,'show']);
Route::get('/fixedasset/{var_codigo}', [FixedassetController::class, 'show']);

//APIS QUE VAN A NECESITAR VALIDACION
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        // Su lógica aquí
    });

    Route::post('/maintenances', [MaintenancesController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'Logout']);
});

