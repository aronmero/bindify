<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\Commerce;
use App\Models\Customer;
use App\Models\User;
use App\Models\Verification_token;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;


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
     *   "username": nombre_usuario,
     *   "token": "access_token",
     *   "tipo": ["rol_1", "rol_2", ...]
     * }
     *
     * @response 404 {
     *   "error": "Usuario no encontrado"
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
                    'username' => $user->username,
                    'token' => $token,
                    'tipo' => $tipo[0]
                ]
            ];

            return response()->json($response, 201);
        }

        return response()->json(['status' => false, 'error' => 'Usuario no encontrado'], 404);
    }

    /**
     * @param \Illuminate\Http\Request $request - El token del usuario.
     *
     * @return \Illuminate\Http\JsonResponse - Un mensaje indicando que se cerro la sesión o un mensaje de error.
     * 
     * @response 200 {
     *   "message": "Sesión Cerrada Correctamente"
     * }
     *
     * @response 401 {
     *   "error": "Usuario no autenticado"
     * }
     */
    public function logout(request $request)
    {
        // Comprueba que el usuario esta autenticado
        if (Auth::check()) {

            $request->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return response()->json(['status' => true, 'message' => 'Sesión Cerrada Correctamente'], 200);
        } else {
            return response()->json(['status' => false, 'error' => 'Usuario no autenticado'], 401);
        }

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
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $banner = $request->file('banner');
            Storage::disk('avatars')->putFileAs($request->username , $avatar, 'imagenPerfil.webp');
            Storage::disk('avatars')->putFileAs($request->username , $banner, 'banner.webp');


        /*     return response()->json([
                'success' => true,
                'empresa' => $request->empresa,
                'message' => 'Avatar received successfully',
                'avatar_name' => $avatar->getClientOriginalName(),
                'avatar_size' => $avatar->getSize(),
                'existe_archivo' => Storage::disk('avatars')->exists($request->username),
                'avatar_url' => asset('storage/avatars/'.$request->username.'/imagenPerfil.webp'),
            ]); */
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No avatar file attached'
            ], 400);
        }
        if ($request->empresa == true) {
            $request->validate([
                'phone' => 'required', // Establece las reglas para el avatar
            ]);
        }

        // Manejo de la imagen/avatar (Esto supuestamente guarda en la carpeta storage/avatars , la imagen del avatar  )
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
                'avatar' => asset('storage/avatars/'.$request->username.'/imagenPerfil.webp'),
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

                $verification_token_id = null;

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
            'status' => true,
            'message' => 'Usuario creado correctamente',
            'user' => $user,
            'token' => $token,
            'tipo' => $tipo,
        ];


        return response()->json($response, 201);
    }
}
