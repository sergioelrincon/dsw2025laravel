<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validamos que nos envíen los datos necesarios
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required', // Nombre para identificar desde dónde se conectan
        ]);

        // 2. Buscamos al usuario por su email
        $user = User::where('email', $request->email)->first();

        // 3. Comprobamos si el usuario existe y si la contraseña es correcta
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Las credenciales son incorrectas.'
            ], 401); // 401 significa "No autorizado"
        }

        // 4. Generamos el token
        // Usamos el 'device_name' para que el usuario sepa qué dispositivo tiene permiso
        $token = $user->createToken($request->device_name)->plainTextToken;

        // 5. Devolvemos el token en formato JSON
        return response()->json([
            'token' => $token,
            'type' => 'Bearer', // Es el tipo de token estándar
        ]);
    }
}
