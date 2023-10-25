<?php

namespace App\Http\Controllers\admin;

use App\Models\Fixedasset;
use App\Http\Controllers\Controller;
class FixedassetController extends Controller
{

    public function show($var_codigo){
        $fixedasset = Fixedasset::select('var_marca', 'var_modelo', 'var_serie','idf_subfamiliaactivo')
            ->where('var_codigo', $var_codigo)
            ->first(); // Usamos first() para obtener el primer registro que coincida

        if($fixedasset){
            return response()->json([
                'status'=>200,
                'fixedasset'=>$fixedasset
            ],200);
        }else{
            return response()->json([
                'status' =>404,
                'message' => 'No hay equipo registrado con ese código'
            ],404);
        }
    }

}

