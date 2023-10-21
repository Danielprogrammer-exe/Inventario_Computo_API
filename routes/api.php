<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\MaintenancesController;
use App\Http\Controllers\admin\FixedassetController;
use App\Http\Controllers\admin\DevicesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//APIS QUE NO NECESITAN VALIDACION
Route::post('/register', [AuthController::class, 'Register']);
Route::post('/login', [AuthController::class, 'login']);

//Route::post('/maintenances',[MaintenancesController::class,'store']);
//Route::get('/maintenances/{id}/edit',[MaintenancesController::class,'edit']);
//Route::put('/maintenances/{id}/edit',[MaintenancesController::class,'update']);

Route::get('devices/',[DevicesController::class,'index']);
Route::get('devices/{id}',[DevicesController::class,'show']);

//CON LA BASE DE DATOS DE WALTER
//Route::get('/fixedasset',[FixedassetController::class,'index']);
Route::get('/fixedasset/{var_codigo}', [FixedassetController::class, 'show']);

//Route::post('/maintenances', [MaintenancesController::class, 'store']);
/*Route::get('/maintenances', [MaintenancesController::class, 'index']);*/

//APIS QUE VAN A NECESITAR VALIDACION
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    Route::post('/maintenances', [MaintenancesController::class, 'store']);

});
