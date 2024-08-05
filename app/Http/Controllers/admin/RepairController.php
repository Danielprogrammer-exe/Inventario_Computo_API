<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Models\Repair;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RepairController extends Controller
{

    public function store(Request $request){
        if (empty($request->status)){
            $request->merge(['status'=> '1']);
        }
    
        // Verificar que final_state esté presente y no sea null
        if (!$request->has('final_state') || $request->input('final_state') === null) {
            return response()->json([
                'status' => 400,
                'error' => 'El campo final_state es requerido y no puede ser null.',
            ], 400);
        }
    
        $validator = Validator::make($request->all(), [
            'code_device' => 'required|string',
            'initial_state' => 'required|string',
            'diagnosis' => 'required|string',
            'solution' => 'required|string',
            'final_state' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => 'Error de validación',
                //'errors' => $validator->errors(),
            ], 400);
        }
        
        $loggedInUser = Auth::user()->name;
    
        $repair = new Repair();
        $repair->fill($request->all());
        $repair->name_user = $loggedInUser;
        $repair->save();
    
        return response()->json([
            'status' => 201,
            'message' => 'Reparación registrada satisfactoriamente.',
            'data' => $repair,
        ], 200);
    }
    
    public function listRepairsByDateRange(Request $request)
            {
    try {
        $from = Carbon::createFromFormat('d-m-Y', $request->query('from'))->format('Y-m-d');
        $to = Carbon::createFromFormat('d-m-Y', $request->query('to'))->format('Y-m-d');

        $repairs = Repair::whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get();

        if ($repairs->isEmpty()) {
            return response()->json(['status' => 200, 'message' => 'No hay reparaciones registradas en el rango de fechas seleccionados.'], 200);
        }

        return response()->json(['status' => 200, 'repairs' => $repairs], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 500, 'message' => 'Error en el formato de la fecha'], 500);
    }
    }

    /*public function getCombinedData(Request $request)
    {
        try{
        // Validar las fechas de inicio y fin del rango
        $from = Carbon::createFromFormat('d-m-Y', $request->query('from'))->format('Y-m-d');
        $to = Carbon::createFromFormat('d-m-Y', $request->query('to'))->format('Y-m-d');

        // Obtener datos de mantenimientos y reparaciones dentro del rango de fechas
        $maintenances = Maintenance::whereBetween('created_at', [$from, $to])->get();
        $repairs = Repair::whereBetween('created_at', [$from, $to])->get();

        // Combinar y ordenar los datos
        $combined = $maintenances->merge($repairs)->sortBy('created_at')->values();

        // Devolver la respuesta en formato JSON
        return response()->json(['status' => 200, 'combined' => $combined],200);

    } catch (\Exception $e){
        return response() ->json((['status'=> 500, 'message' => 'Error en el formato de la fecha']), 500);
    }
    }*/

}
