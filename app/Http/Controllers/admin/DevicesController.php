<?php

namespace App\Http\Controllers\admin;

use App\Models\Devices;
use App\Http\Controllers\Controller;

class DevicesController extends Controller
{
    public function show($code){
        /*if (!Auth::check()) {
            return response()->json([
                'status' => 401,
                'message' => 'No autorizado'
            ], 401);
        }*/

        $devices = Devices::select('brand', 'model', 'serie','type_device')
            ->where('code', $code)
            ->first();  // Usamos first() para obtener el primer registro que coincida

        if($devices){
            return response()->json([
                'status'=>200,
                'devices'=>$devices
            ],200);
        }else{
            return response()->json([
                'status' =>404,
                'message' => 'No hay equipo registrado con este código'
            ],404);
        }
    }
}
