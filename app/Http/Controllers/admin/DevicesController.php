<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Devices;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function index()
    {
        $devices=Devices::all();
        if($devices->count()>0){
            return response()->json([
                'status'=>200,
                'students'=>$devices
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'students'=>'No hay registro de equipos.'
            ],404);
        }
    }

    public function show($id){
        $device = Devices::find($id);
        if($device){
            return response()->json([
                'status'=>200,
                'device'=>$device
            ],200);
        }else{
            return response()->json([
                'status' =>404,
                'message' => 'No hay equipo registrado con ese código'
            ],404);
        }
    }

    public function destroy(Devices $device){
        $device->delete();
        $rsp = [
            'ok' => true,
            'msg' => 'Delete success',
            'data' => $device,
        ];
        return response()->json($rsp);
    }
}
