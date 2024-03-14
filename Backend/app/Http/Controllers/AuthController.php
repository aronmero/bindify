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
     * @OA\Post(
     *     path="/login",
     *     summary="Iniciar sesión de usuario",
     *     description="Verifica las credenciales del usuario y genera un token de acceso si son válidas.",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos de inicio de sesión del usuario",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="usuario@example.com"),
     *             @OA\Property(property="password", type="string", example="contraseña_secreta")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Inicio de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="object",
     *                 @OA\Property(property="username", type="string", example="nombre_de_usuario"),
     *                 @OA\Property(property="token", type="string", example="access_token"),
     *                 @OA\Property(property="tipo", type="string", example="rol")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Usuario no encontrado")
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/logout",
     *     summary="Cierra la sesión del usuario actual",
     *     description="Este método cierra la sesión del usuario actual y revoca todos los tokens de acceso asociados.",
     *     operationId="logoutUser",
     *     tags={"Autenticación"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\RequestBody(
     *         required=true,
     *         description="El token del usuario.",
     *         @OA\JsonContent(
     *             required={"token"},
     *             @OA\Property(property="token", type="string", example="token_de_acceso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sesión cerrada correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Sesión cerrada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Usuario no autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Usuario no autenticado")
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/register",
     *     summary="Maneja la solicitud de registro de usuarios.",
     *     description="Este método crea un nuevo usuario con los datos proporcionados en la solicitud. Asigna un rol al usuario (comercio, cliente o ayuntamiento) según los datos proporcionados. Devuelve una respuesta JSON con un mensaje de éxito y los detalles del usuario creado.",
     *     operationId="registerUser",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos de la solicitud de registro de usuario",
     *         @OA\JsonContent(
     *             required={"email", "password", "phone", "username", "empresa", "name"},
     *             @OA\Property(property="email", type="string", example="usuario@example.com"),
     *             @OA\Property(property="password", type="string", example="contraseña_secreta"),
     *             @OA\Property(property="phone", type="integer", example="654781238"),
     *             @OA\Property(property="username", type="string", example="nombre_usuario"),
     *             @OA\Property(property="municipality_id", type="integer", example="id_municipio"),
     *             @OA\Property(property="empresa", type="boolean", example="true"),
     *             @OA\Property(property="name", type="string", example="nombre_real"),
     *             @OA\Property(property="verification_toke", type="integer", example="token_ayuntamiento"),
     *             @OA\Property(property="avatar", type="file", example="imagen_perfil"),
     *             @OA\Property(property="banner", type="file", example="banner"),
     *             @OA\Property(property="gender", type="string", example="genero_particular"),
     *             @OA\Property(property="address", type="string", example="direccion_empresa"),
     *             @OA\Property(property="schedule", type="string", example="horario_empresa"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Usuario creado correctamente"),
     *             @OA\Property(property="user", type="object", example="User"),
     *             @OA\Property(property="token", type="string", example="access_token"),
     *             @OA\Property(property="tipo", type="array", @OA\Items(type="string", example="rol_1"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos de creación de usuario incorrectos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Datos de creación de usuario incorrectos"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Token de verificación incorrecto",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Token de verificación incorrecto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Mensaje de error")
     *         )
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {


        $rutaAvatar = 'default';
        $rutaBanner = 'default';

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            Storage::disk('avatars')->putFileAs($request->username, $avatar, 'imagenPerfil.webp');
            $rutaAvatar = asset('storage/avatars/' . $request->username . '/imagenPerfil.webp');
        }

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            Storage::disk('avatars')->putFileAs($request->username, $banner, 'banner.webp');
            $rutaBanner = asset('storage/avatars/' . $request->username . '/banner.webp');
        }


        if ($request->empresa == true) {
            $request->validate([
                'phone' => 'required', // Establece las reglas para el avatar
            ]);
        }


        // Creación del usuario
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'municipality_id' => $request->municipality_id,
                'avatar' => $rutaAvatar,
                'banner' => $rutaBanner,
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
