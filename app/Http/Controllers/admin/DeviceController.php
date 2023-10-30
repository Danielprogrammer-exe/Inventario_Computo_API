<?php

namespace App\Http\Controllers\admin;

use App\Models\Device;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    //LISTA TODOS LOS DISPOSITIVOS REGISTRADOS
    public function index()
    {
        $devices = DB::table('devices')->get();
        return response()->json($devices);
    }

    //AGREGA UN DISPOSITIVO A LA TABLA DEVICES
    public function store(Request $request)
    {
        if (Auth::check()) {
            // Validaciones de los campos, añadiendo el campo 'status'
            $validator = Validator::make($request->all(), [
                'code' => 'required|unique:devices,code',
                'brand' => 'required',
                'model' => 'required',
                'serie' => 'required',
                'type_device' => 'required',
                'status' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $device = Device::create($request->all());
            return response()->json(['message' => 'Equipo agregado satisfactoriamente', 'data' => $device], 201);
        } else {
            return response()->json(['error' => 'No autorizado'], 401);
        }
    }

    public function show($code)
    {
        $devices = Device::select('brand', 'model', 'serie','type_device', 'status') // Se añade 'status'
        ->where('code', $code)
            ->first();

        if($devices){
            return response()->json([
                'status' => 200,
                'devices' => $devices
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No hay equipo registrado con este código'
            ], 404);
        }
    }

    public function update(Request $request, $code)
    {
        if (Auth::check()) {
            $device = Device::where('code', $code)->first();
            if (!$device) {
                return response()->json(['error' => 'Dispositivo no encontrado'], 404);
            }

            $validator = Validator::make($request->all(), [
                'code' => 'sometimes|unique:devices,code,' . $device->id,
                'brand' => 'sometimes|required',
                'model' => 'sometimes|required',
                'serie' => 'sometimes|required',
                'type_device' => 'sometimes|required',
                'status' => 'sometimes|required|string' // Se añade 'status'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $device->update($request->all());
            return response()->json(['message' => 'Dispositivo actualizado exitosamente', 'data' => $device], 200);
        } else {
            return response()->json(['error' => 'No autorizado'], 401);
        }
    }

    //ELIMINA EL REGISTRO DE UN  DISPOSITIVO EN LA TABLA DEVICES BUSCADO POR SU ID, NO POR LE CAMPO CODE
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
        $qrData = "Code: {$device->code} | Date: {$currentDate}";

        // Dinámicamente generar la cadena ZPL
        $zpl_string = "^XA
       ^FO100,100
       ^BQN,2,10
       ^FDMA,{$device->code}^FS
       ^FO100,300^A0N,50,50^FD{$device->code}^FS
       ^FO100,400^A0N,50,50^FDBrand: {$device->brand}^FS
       ^FO100,500^A0N,50,50^FDType: {$device->type_device}^FS
       ^FO200,600^BQN,2,7
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
