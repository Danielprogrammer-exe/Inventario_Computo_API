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

    // Agregar un registro de Reparacion
    public function store(Request $request){
        if (empty($request->status)){
            $request->merge(['status'=> '1']);
        }

        $validator = Validator::make($request->all(), [
            'code_device' => 'required|string',
            'name_user' => 'required|string',
            'initial_state' => 'required|string',
            'diagnosis' => 'required|string',
            'solution' => 'required|string',
            'final_state' => 'required|string',
        ]);
        
        $loggedInUser = Auth::user()->name;

    $repair = new Repair();
    $repair->fill($request->all());
    $repair->name_user = $loggedInUser;
    $repair->save();

    return response()->json([
        'status' => 200,
        'message' => 'Reparación registrada satisfactoriamente.',
        'data' => $repair,
    ], 200);

    }



}
