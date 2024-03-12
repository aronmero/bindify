<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Commerce;
use App\Models\Customer;
use App\Models\User;
use App\Models\Verification_token;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
                'status' => true,
                'message' => [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'token' => $token,
                    'tipo' => $tipo[0]
                ]
            ];

            return response()->json($response, 201);
        }

        return response()->json(['status' => false, 'error' => 'Ususario no encontrado'], 404);
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
        // Validación de la solicitud
        if ($request->empresa == true) {
            $request->validate([
                'phone' => 'required',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Establece las reglas para el avatar
            ]);
        }

        // Manejo de la imagen/avatar
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public'); // Guarda la imagen en el almacenamiento 'public/avatars'
        }

        // Creación del usuario
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'municipality_id' => $request->municipality_id,
                'avatar' => $avatarPath, // Guarda la ruta del avatar en la base de datos
                'username' => $request->username,
                'name' => $request->name
            ]);
        } catch (Exception $th) {
            return response()->json(['status' => false, 'message' => 'Datos de creacion de usuario incorrectos', 'error' => $th->getMessage()], 500);
        }



        $credentials = $request->only('email', 'password');
        try {
            Auth::attempt($credentials);
        } catch (AuthorizationException $e) {
            return response()->json(['status' => false, 'message' => 'Usuario no encontrado', 'error' => $e->getMessage()], 500);
        }
        if ($request->empresa) {
            try {
                if ($request->verification_token != null) {
                    $verification_token_id = Verification_token::select('id')->where('token', '=', $request->verification_token)->firstOrFail();
                    $user->assignRole('ayuntamiento');
                } else {
                    $user->assignRole('commerce');
                }
            } catch (ModelNotFoundException $e) {
                $user->delete();
                return response()->json(["status" => false, 'error' => 'Token de verificación incorrecto'], 404);
            } catch (Exception $th) {
                $user->delete();
                return response()->json(["status" => false, 'error' => $th->getMessage()], 500);
            }
            try {
                $commerce = Commerce::create([
                    'user_id' => $user->id,
                    'address' => $request->address,
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'verification_token_id' => $verification_token_id,
                    'verificated' => false,
                    'schedule' => $request->schedule,
                    'active' => true,
                ]);
            } catch (Exception $th) {
                $user->delete();
                return response()->json(['status' => false, 'message' => 'Datos de creacion de comercion erroneos', 'error' => $th->getMessage()], 500);
            }
        } else {
            try {
                $user->assignRole('customer');
            } catch (Exception $th) {
                $user->delete();
                return response()->json(['status' => false, 'error' => $th->getMessage()], 500);
            }
            try {
                $customer = Customer::create([
                    'user_id' => $user->id,
                    'gender' => $request->gender,
                    'birth_date' => $request->birth_date,
                ]);
            } catch (Exception $th) {
                $user->delete();
                return response()->json(['status' => false, 'message' => 'Datos de creacion de comercio erroneos', 'error' => $th->getMessage()], 500);
            }
        }

        $token = $user->createtoken('my_app_token')->plainTextToken;
        $tipo = $user->getRoleNames();

        $response = [
            'message' => 'Usuario creado correctamente',
            'user' => $user,
            'token' => $token,
            'tipo' => $tipo,
        ];


        return response()->json($response, 201);
    }
}
