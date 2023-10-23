<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenancesController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->all();

        if (Auth::check()) {
            $data['name_user'] = Auth::user()->name;
        } else {
            return response()->json(['error' => 'No hay usuario autenticado'], 401);
        }

        $maintenance = Maintenance::create($data);
        return response()->json($maintenance, 201);
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
