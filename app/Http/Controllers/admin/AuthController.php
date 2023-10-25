<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function Register(Request $R)
    {
        try {
            $cred = new User();
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
        // Buscar usuario por email
        $user = User::where('email', $R->email)->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($user && Hash::check($R->password, $user->password)) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = ['success' => true,'status' => 200, 'token' => $token, 'user' => $user, 'message' => 'Bienvenido!'];
            return response()->json($response, 200);
        }

        // Devolver mensaje de error si el usuario no se encuentra o si la contraseña es incorrecta
        $response = ['status' => 401, 'message' => 'Credenciales incorrectas'];
        return response()->json($response, 401);
    }

    public function Logout(Request $request)
    {
        try {
            // Obtener el usuario actual basado en el token
            $user = $request->User();

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
