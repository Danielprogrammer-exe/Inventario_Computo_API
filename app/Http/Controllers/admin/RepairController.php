<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
    

}
