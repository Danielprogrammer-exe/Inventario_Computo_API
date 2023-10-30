<?php
//Se importa los controladores que se van a utilizar
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\MaintenanceController;
use App\Http\Controllers\admin\DeviceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Registrar un usuario nuevo
Route::post('/register', [AuthController::class, 'Register']);
//Acceder al sistema, genera un token
Route::post('/login', [AuthController::class, 'login']);
//Listar todos los equipos registrados
Route::get('/listDevice', 'App\Http\Controllers\admin\DeviceController@index');
//Buscar un equipo por su codigo
Route::get('/device/{code}',[DeviceController::class,'show']);
//Listar los mantenimientos en un rango de fechas
Route::post('/maintenanceslistbydaterange', [MaintenanceController::class, 'listByDateRange']);
//IMPRIMIR EN TICKETERA ZEBRA ZD230
Route::post('/print', [DeviceController::class, 'printDeviceLabel']);

//APIS Que necesitan autenticacion para ser ejecutadas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        // Su lógica aquí
    });
    //Cerrar Sesion
    Route::post('/logout', [AuthController::class, 'Logout']);
    //Agregar un dispositivo a la tabla devices
    Route::post('/store-device', [DeviceController::class, 'store']);
    //Modificar los datos registrados de un dispositivo
    Route::put('/device/{code}', 'App\Http\Controllers\admin\DeviceController@update');
    //Agregar registro de un mantenimiento
    Route::post('/store-maintenance', [MaintenanceController::class, 'store']);
    //Modificar datos de un mantenimineto
    Route::put('/maintenance/{id}', [MaintenanceController::class, 'updateMaintenance']);
    //🚩⚠Eliminar permanentemente el registro de un mantenimiento🚩⚠
    Route::delete('/delete-device/{id}', [DeviceController::class, 'destroy']);
    //🚩⚠Eliminar permanentemente el registro de un dispositivo🚩⚠
    Route::delete('/delete-maintenance/{id}', [MaintenanceController::class, 'destroy']);

});
