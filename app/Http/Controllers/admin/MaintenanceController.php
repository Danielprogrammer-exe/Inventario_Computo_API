<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{

    //Agregar un registro de mantenimiento
    public function store(Request $request)
    {
        if (empty($request->status)) {
            $request->merge(['status' => '1']);
        }

        $validator = Validator::make($request->all(), [
            'code_device' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        // Validación para verificar si ya se ha agregado un mantenimiento hoy
        $existingMaintenance = Maintenance::where('code_device', $request->code_device)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($existingMaintenance) {
            return response()->json([
                'status' => 422,
                'error' => 'No se puede dar mas de 1 mantenimiento al mismo dispositivo por dia. Si algo falló, modificar el mantenimiento en la seccion de [Mis mantenimientos].'
            ], 422);
        }

        $loggedInUser = Auth::user()->name;
        $maintenance = new Maintenance();
        $maintenance->fill($request->all());

        $booleanFields = [
            'soplado_general',
            'ventiladores',
            'disipador_del_procesador',
            'ranuras_de_expansion',
            'tarjetas_de_memoria',
            'fuente_de_poder',
            'lectora_de_CD_DVD',
            'monitor',
            'teclado',
            'mouse',
            'desfragmentado_de_disco_scandisk',
            'mantenimiento_de_archivos',
            'asistente_para_quitar_programas',
            'eliminacion_de_archivos_temporales',
            'eliminacion_de_cookies_y_archivos_temporales',
            'analisis_con_antivirus',
            'antiSpyware',
            'analisis_de_registro',
            'prueba_de_impresion_antes_del_mantenimiento',
            'impresion_pagina_de_configuracion',
            'verificacion_del_contador_de_paginas_impresas',
            'verificacion_del_estado_de_los_consumibles',
            'limpieza_de_los_consumibles',
            'verificacion_de_los_mecanismos_de_impresion',
            'limpieza_de_los_mecanismos_de_impresion',
            'limpieza_externa_del_equipo',
            'prueba_de_impresion_despues_del_mantenimiento'
        ];

        foreach ($booleanFields as $field) {
            // Si el campo existe en la solicitud, establece su valor en true; de lo contrario, en false
            $maintenance->{$field} = $request->input($field, false);
        }

        $maintenance->name_user = $loggedInUser;
        $maintenance->code_device = $request->code_device;
        $maintenance->observations = $request->observations;
        $maintenance->save();

        return response()->json([
            'status' => 200,
            'message' => 'Mantenimiento registrado satisfactoriamente'
        ], 200);
    }

    public function listByDateRange(Request $request)
    {
        try {
            $from = Carbon::createFromFormat('d-m-Y', $request->query('from'))->format('Y-m-d');
            $to = Carbon::createFromFormat('d-m-Y', $request->query('to'))->format('Y-m-d');

            $maintenances = Maintenance::whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->get();

            return response()->json(['status' => 200, 'maintenances' => $maintenances], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error en el formato de la fecha'], 500);
        }
    }

    public function getMaintenancesById($id)
    {
        $maintenances = Maintenance::where('id', $id)->get();

        if ($maintenances->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No existe mantenimiento con ese ID.'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'maintenances' => $maintenances,
        ], 200);
    }

    //Modificar mantenimiento
    public function updateMaintenance(Request $request, $id)
    {
        // Busca el mantenimiento existente por su ID
        $maintenance = Maintenance::find($id);

        // Verifica si el mantenimiento existe
        if (!$maintenance) {
            return response()->json([
                'status' => 404,
                'message' => 'Mantenimiento no encontrado'
            ], 404);
        }

        // Actualiza los campos necesarios
        $booleanFields = [
            'soplado_general',
            'ventiladores',
            'disipador_del_procesador',
            'ranuras_de_expansion',
            'tarjetas_de_memoria',
            'fuente_de_poder',
            'lectora_de_CD_DVD',
            'monitor',
            'teclado',
            'mouse',
            'desfragmentado_de_disco_scandisk',
            'mantenimiento_de_archivos',
            'asistente_para_quitar_programas',
            'eliminacion_de_archivos_temporales',
            'eliminacion_de_cookies_y_archivos_temporales',
            'analisis_con_antivirus',
            'antiSpyware',
            'analisis_de_registro',
            'prueba_de_impresion_antes_del_mantenimiento',
            'impresion_pagina_de_configuracion',
            'verificacion_del_contador_de_paginas_impresas',
            'verificacion_del_estado_de_los_consumibles',
            'limpieza_de_los_consumibles',
            'verificacion_de_los_mecanismos_de_impresion',
            'limpieza_de_los_mecanismos_de_impresion',
            'limpieza_externa_del_equipo',
            'prueba_de_impresion_despues_del_mantenimiento'
        ];

        foreach ($booleanFields as $field) {
            // Si el campo existe en la solicitud, establece su valor; de lo contrario, deja el valor actual
            $maintenance->{$field} = $request->boolean($field, $maintenance->{$field});
        }

        // Actualiza otros campos
        $maintenance->observations = $request->observations;

        // Guarda los cambios
        $maintenance->save();

        return response()->json([
            'status' => 200,
            'message' => 'Mantenimiento actualizado satisfactoriamente'
        ], 200);
    }

    public function destroy($id)
    {
        // Buscar el registro de mantenimiento por su ID
        $maintenance = Maintenance::find($id);

        // Verificar si el registro de mantenimiento existe
        if(!$maintenance) {
            return response()->json([
                'message' => 'Registro de mantenimiento no encontrado',
            ], 404);
        }

        // Eliminar el registro de mantenimiento
        $maintenance->delete();

        return response()->json([
            'message' => 'Registro de mantenimiento eliminado con éxito',
        ], 200);
    }

}
