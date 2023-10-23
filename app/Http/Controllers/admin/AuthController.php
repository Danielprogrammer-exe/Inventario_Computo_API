<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function Register(Request $R)
    {
        try {
            $cred = new Users();
            $cred->name = $R->name;
            $cred->email = $R->email;
            $cred->password = Hash::make($R->password);
            $cred->save();
            $response = ['status' => 200, 'message' => 'Registro Existoso! Bienvenido!'];
            return response()->json($response);
        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => $e];
        }
    }

    function Login(Request $R){
        $user = Users::where('email', $R->email)->first();

        if($user!='[]' && Hash::check($R->password,$user->password)){
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = ['status' => 200, 'token' => $token, 'user' => $user, 'message' => 'Bienvenido!'];
            return response()->json($response);
        }else if($user=='[]'){
            $response = ['status' => 500, 'message' => 'Usuario no encontrado'];
            return response()->json($response);

        }else{
            $response = ['status' => 500, 'message' => 'Email o contraseña incorrecta'];
            return response()->json($response);
        }
    }

    public function Logout(Request $request)
    {
        try {
            // Obtener el usuario actual basado en el token
            $user = $request->user();

            // Revocar el token actual
            $user->currentAccessToken()->delete();

            $response = ['status' => 200, 'message' => 'Sesión cerrada exitosamente.'];
            return response()->json($response);

        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => $e->getMessage()];
            return response()->json($response);
        }
    }

}
