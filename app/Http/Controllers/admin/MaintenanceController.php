<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{
    //Agregar un registro de mantenimiento
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_device' => 'required|string',
            'status' => [
                'required',
                Rule::in(['Operativo', 'Operativo con fallas', 'No operativo']),
            ],
            'soplado_general' => 'boolean',
            'ventiladores' => 'boolean',
            'disipador_del_procesador' => 'boolean',
            'ranuras_de_expansion' => 'boolean',
            'tarjetas_de_memoria' => 'boolean',
            'fuente_de_poder' => 'boolean',
            'lectora_de_CD_DVD' => 'boolean',
            'monitor' => 'boolean',
            'teclado' => 'boolean',
            'mouse' => 'boolean',
            'desfragmentado_de_disco_Scandisk' => 'boolean',
            'mantenimiento_de_archivos' => 'boolean',
            'asistente_para_quitar_programas' => 'boolean',
            'eliminacion_de_archivos_temporales' => 'boolean',
            'eliminacion_de_cookies_y_archivos_temporales' => 'boolean',
            'analisis_con_antivirus' => 'boolean',
            'antiSpyware' => 'boolean',
            'analisis_de_registro' => 'boolean',
            'prueba_de_impresion_antes_del_mantenimiento' => 'boolean',
            'impresion_pagina_de_configuracion' => 'boolean',
            'verificacion_del_contador_de_paginas_impresas' => 'boolean',
            'verificacion_del_estado_de_los_consumibles' => 'boolean',
            'limpieza_de_los_consumibles' => 'boolean',
            'verificacion_de_los_mecanismos_de_impresion' => 'boolean',
            'limpieza_de_los_mecanismos_de_impresion' => 'boolean',
            'limpieza_externa_del_equipo' => 'boolean',
            'prueba_de_impresion_despues_del_mantenimiento' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $loggedInUser = Auth::user()->name;
        $maintenance = new Maintenance();
        $maintenance->fill($request->all());
        // Establecer valores por defecto para los campos booleanos si no están presentes en la solicitud
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
            if (!$maintenance->isDirty($field)) {
                $maintenance->{$field} = false;
            }
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
            $from = Carbon::createFromFormat('d-m-Y', $request->input('from'))->format('Y-m-d');
            $to = Carbon::createFromFormat('d-m-Y', $request->input('to'))->format('Y-m-d');

            $maintenances = Maintenance::whereBetween('created_at', [$from, $to])->get();

            return response()->json(['status' => 200, 'maintenances' => $maintenances], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error en el formato de la fecha'], 500);
        }
    }

    //Modificar mantenimiento
    public function updateMaintenance(Request $request, $id)
    {
        try {
            $maintenance = Maintenance::findOrFail($id);

            // Filtrar los campos que sí se pueden actualizar
            $allowedUpdates = [
                'observations',
                'status',
                'soplado_general',
                'ventiladores',
                'observations',
                'status',
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

            $input = $request->only($allowedUpdates);

            // Validaciones
            $validator = Validator::make($request->all(), [
                'code_device' => 'required|string',
                'status' => [
                    'required',
                    Rule::in(['Operativo', 'Operativo con fallas', 'No operativo']),
                ],
                'soplado_general' => 'required|boolean',
                'ventiladores' => 'required|boolean',
                'disipador_del_procesador' => 'required|boolean',
                'ranuras_de_expansion' => 'required|boolean',
                'tarjetas_de_memoria' => 'required|boolean',
                'fuente_de_poder' => 'required|boolean',
                'lectora_de_CD_DVD' => 'required|boolean',
                'monitor' => 'required|boolean',
                'teclado' => 'required|boolean',
                'mouse' => 'required|boolean',
                'desfragmentado_de_disco_scandisk' => 'required|boolean',
                'mantenimiento_de_archivos' => 'required|boolean',
                'asistente_para_quitar_programas' => 'required|boolean',
                'eliminacion_de_archivos_temporales' => 'required|boolean',
                'eliminacion_de_cookies_y_archivos_temporales' => 'required|boolean',
                'analisis_con_antivirus' => 'required|boolean',
                'antiSpyware'=> 'required|boolean',
                'analisis_de_registro' => 'required|boolean',
                'prueba_de_impresion_antes_del_mantenimiento' => 'required|boolean',
                'impresion_pagina_de_configuracion' => 'required|boolean',
                'verificacion_del_contador_de_paginas_impresas' => 'required|boolean',
                'verificacion_del_estado_de_los_consumibles' => 'required|boolean',
                'limpieza_de_los_consumibles' => 'required|boolean',
                'verificacion_de_los_mecanismos_de_impresion' => 'required|boolean',
                'limpieza_de_los_mecanismos_de_impresion' => 'required|boolean',
                'limpieza_externa_del_equipo' => 'required|boolean',
                'prueba_de_impresion_despues_del_mantenimiento' => 'required|boolean'
            ]);

            // Actualizar en la base de datos
            $maintenance->update($input);

            return response()->json([
                'status' => 200,
                'message' => 'Mantenimiento actualizado exitosamente',
                'maintenance' => $maintenance
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error al actualizar el mantenimiento'
            ], 500);
        }
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
