<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Commerce;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Maneja la solicitud de inicio de sesión.
     *
     * Este método verifica las credenciales del usuario y genera un token de acceso si las credenciales son válidas.
     * Devuelve una respuesta JSON con el token de acceso y el tipo de usuario si la autenticación es exitosa.
     * Si las credenciales son inválidas, devuelve una respuesta JSON con un mensaje de error y un estado 404.
     *
     * @param \App\Http\Requests\LoginRequest $datos - Los datos de la solicitud de inicio de sesión.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON que contiene el token de acceso y el tipo de usuario o un mensaje de error.
     *
     * Ejemplo de la solicitud
     * 
     * @response 201 { 
     *   "user_id": 1,
     *   "token": "access_token",
     *   "tipo": ["rol_1", "rol_2", ...]
     * }
     *
     * @response 404 {
     *   "error": "Ususario no encontrado"
     * }
     */
    public function login(LoginRequest $datos)
    {
        $credenciales = $datos->only('email', 'password');
        if (Auth::attempt($credenciales)) {
            $user = User::where('email', $datos->email)->first();
            $tipo = $user->getRoleNames();
            
            $token = $user->createtoken('my_app_token')->plainTextToken;

            $response = [
                'user_id' => $user->id,
                'token' => $token,
                'tipo' => $tipo
            ];

            return response($response, 201);
        }

        return response()->json(['error' => 'Ususario no encontrado'], 404);
    }

    /**
     * Maneja la solicitud de registro de usuarios.
     *
     * Este método crea un nuevo usuario con los datos proporcionados en la solicitud.
     * Asigna un rol al usuario (comercio, cliente o ayuntamiento) según los datos proporcionados.
     * Devuelve una respuesta JSON con un mensaje de éxito y los detalles del usuario creado.
     *
     * @param \App\Http\Requests\RegisterRequest $request - Los datos de la solicitud de registro de usuario.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON que contiene un mensaje de éxito y los detalles del usuario creado.
     *
     * @response 201 {
     *   "message": "Usuario creado correctamente",
     *   "user": {
     *     Detalles del usuario
     *   }
     * }
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'municipality_id' => $request->municipality_id,
            'avatar' => $request->avatar,
            'username' => $request->username,
            'name' => $request->name
        ]);

        
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        if ($request->empresa) {
            if ($request->verificationToken != null) {
                $user->assignRole('ayuntamiento');
            } else {
                $user->assignRole('comercio');
            }

            $commerce = Commerce::create([
            'user_id' => $user->id,
            'address' => $request->address,
            'description' => $request->description,
            'verification_token_id' => $request->verification_token_id,
            'category_id' => $request->category_id,
            'verificated'=> false,
            'schedule' => $request->schedule
        ]);
            $commerce->user()->attach($user->id);
        } else {
            $user->assignRole('cliente');
            $customer = Customer::create([
                'user_id' => $user->id,
            ]);
            $customer->user()->attach($user->id);
        }


        $response = [
            'message' => 'Usuario creado correctamente',
            'user' => $user,
        ];


        return response($response, 201);
    }
}
