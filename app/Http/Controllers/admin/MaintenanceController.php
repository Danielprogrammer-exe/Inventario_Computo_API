<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{

    public function store(Request $request)
    {
        // Obtener el nombre del usuario logeado
        $loggedInUser = Auth::user()->name;

        // Crear un nuevo registro en la tabla maintenances
        $maintenance = new Maintenance([
            'name_user' => $loggedInUser,
            'code_device' => $request->input('code_device'),
            'observations' => $request->input('observations'),
            'status' => $request->input('status'),
            'soplado_general' => $request->input('soplado_general'),
            'ventiladores' => $request->input('ventiladores'),
            'disipador_del_procesador' => $request->input('disipador_del_procesador'),
            'ranuras_de_expansion' => $request->input('ranuras_de_expansion'),
            'tarjetas_de_memoria' => $request->input('tarjetas_de_memoria'),
            'fuente_de_poder' => $request->input('fuente_de_poder'),
            'lectora_de_CD_DVD' => $request->input('lectora_de_CD_DVD'),
            'monitor' => $request->input('monitor'),
            'teclado' => $request->input('teclado'),
            'mouse' => $request->input('mouse'),
            'desfragmentado_de_disco' => $request->input('desfragmentado_de_disco'),
            'scandisk' => $request->input('scandisk'),
            'mantenimiento_de_archivos' => $request->input('mantenimiento_de_archivos'),
            'asistente_para_quitar_programas' => $request->input('asistente_para_quitar_programas'),
            'eliminacion_de_archivos_temporales' => $request->input('eliminacion_de_archivos_temporales'),
            'eliminacion_de_cookies_y_archivos_temporales' => $request->input('eliminacion_de_cookies_y_archivos_temporales'),
            'analisis_con_antivirus_antiSpyware' => $request->input('analisis_con_antivirus_antiSpyware'),
            'analisis_de_registro' => $request->input('analisis_de_registro'),
            'prueba_de_impresion_antes_del_mantenimiento' => $request->input('prueba_de_impresion_antes_del_mantenimiento'),
            'impresion_pagina_de_configuracion' => $request->input('impresion_pagina_de_configuracion'),
            'verificacion_del_contador_de_paginas_impresas' => $request->input('verificacion_del_contador_de_paginas_impresas'),
            'verificacion_del_estado_de_los_consumibles' => $request->input('verificacion_del_estado_de_los_consumibles'),
            'limpieza_de_los_consumibles' => $request->input('limpieza_de_los_consumibles'),
            'verificacion_de_los_mecanismos_de_impresion' => $request->input('verificacion_de_los_mecanismos_de_impresion'),
            'limpieza_de_los_mecanismos_de_impresion' => $request->input('limpieza_de_los_mecanismos_de_impresion'),
            'limpieza_externa_del_equipo' => $request->input('limpieza_externa_del_equipo'),
            'prueba_de_impresion_despues_del_mantenimiento' => $request->input('prueba_de_impresion_despues_del_mantenimiento'),
        ]);

        $maintenance->save();

        //return redirect()->route('/store-maintenance')->with('status', 'Registro de mantenimiento creado exitosamente.');
    }

    /*public function index(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $maintenances = Maintenance::whereBetween('date_created', [$from, $to])->get();

        return response()->json($maintenances);
    }*/



    /*public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_device' => 'required|integer',
            'id_user' => 'required|integer',
            'observations' => 'required|string|max:191',
            'state' => 'required|digits:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }
        $maintenance = Maintenance::create([
            'id_device' => $request->id_device,
            'id_user' => $request->id_user,
            'observations' => $request->observations,
            'state' => $request->state,
        ]);

        if(!$maintenance){
            return response()->json([
                'status' => 500,
                'message' => 'Algo fue mal'
            ], 500);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Mantenimiento ingresado satisfactoriamente!'
        ], 200);
    }

    //AGREGAR PARAMETROS DE FECHAS
    public function show(Maintenance $maintenance){
        $maintenance = Maintenance::find($maintenance);
        if($maintenance){
            return response()->json([
                'status'=>200,
                'maintenance'=>$maintenance
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No hay mantenimientos en este rango de fechas'
            ],404);
        }
    }

    public function edit($id)
    {
        $maintenance = Maintenance::find($id);
        if ($maintenance) {
            return response()->json([
                'status' => 200,
                'maintenance' => $maintenance
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No hay mantenimientos en este rango de fechas'
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'id_device' => 'required|integer',
            'id_user' => 'required|integer',
            'observations' => 'required|string|max:191',
            'state' => 'required|digits:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $maintenance = Maintenance::find($id);

            if ($maintenance) {
                $maintenance->update([
                    'id_device' => $request->id_device,
                    'id_user' => $request->id_user,
                    'observations' => $request->observations,
                    'state' => $request->state,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Mantenimiento modificado satisfactoriamente!'
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No se encontró ningun mantenimiento'
                ], 404);
            }
        }
    }

    public function destroy(Users $user)
    {
        $user->delete();
        $rsp = [
            'ok' => true,
            'msg' => 'Delete success',
            'data' => $user,
        ];
        return response()->json($rsp);
    }*/

}
