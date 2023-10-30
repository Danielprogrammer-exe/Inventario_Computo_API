<?php

namespace App\Http\Controllers\admin;

use App\Models\Device;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{

    /*public function store(Request $request)
    {
        // Validaciones de los campos
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:devices,code',
            'brand' => 'required',
            'model' => 'required',
            'serie' => 'required',
            'type_device' => 'required'
        ]);

        // Si la validación falla
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        // Si pasa la validación
        $device = Device::create($request->all());
        return response()->json(['message' => 'Equipo agregado satisfactoriamente', 'data' => $device], 201);
    }*/

    public function show($code){

        $devices = Device::select('brand', 'model', 'serie','type_device')
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

    public function destroy($id)
    {
        // Buscar el registro del dispositivo por su ID
        $device = Device::find($id);

        // Verificar si el registro del dispositivo existe
        if(!$device) {
            return response()->json([
                'message' => 'Registro de dispositivo no encontrado',
            ], 404);
        }

        // Eliminar el registro del dispositivo
        $device->delete();

        return response()->json([
            'message' => 'Registro de dispositivo eliminado con éxito',
        ], 200);
    }

    //FUNCION PARA IMPRIMIR EN TICKETERA ZEBRA ZD230
    public function printDeviceLabel(Request $request) {
        // Obtener el código del dispositivo de la solicitud
        $deviceCode = $request->get('code');

        // Buscar el dispositivo en la base de datos usando el campo 'code'
        $device = Device::where('code', $deviceCode)->firstOrFail();

        // Generamos la fecha en el formato que necesitemos
        $currentDate = date("Y-m-d");

        // Concatenamos el código del dispositivo y la fecha para el QR
        $qrData = "C:{$device->code} D:{$currentDate}";

        // Dinámicamente generar la cadena ZPL
        $zpl_string = "^XA
        ^FO5,5
        ^BQN,2,2
        ^FDMA,{$device->code}^FS
        ^FO10,30^A0N,10,10^FD{$device->code}^FS
        ^FO10,50^A0N,10,10^FD{$device->brand}^FS
        ^FO10,70^A0N,10,10^FD{$device->type_device}^FS
        ^FO15,90^BQN,2,2
        ^FDHA,{$qrData}^FS
        ^XZ";

        // Enviar a la impresora (asumiendo conexión de red)
        $fp = fsockopen("192.168.0.219", 9100);
        if (!$fp) {
            return response('No se pudo conectar con la impresora', 500);
        } else {
            fwrite($fp, $zpl_string);
            fclose($fp);
            return response('Impresión realizada con éxito', 200);
        }
    }

}
