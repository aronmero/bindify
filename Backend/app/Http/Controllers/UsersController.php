<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Customer;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:admin")->only("destroy");
    }
    /**
     * Muestra la información de un usuario específico.
     *
     * Esta función recibe el nombre de usuario y busca en la base de datos la información correspondiente.
     * Dependiendo del tipo de usuario (cliente o comercio), recopila y devuelve información relevante dependiendo si es un cliente o un comercio en formato JSON.
     * Si no se encuentra el usuario, devuelve un mensaje de error y un estado 404.
     *
     * @param string $username - El nombre de usuario del usuario a mostrar.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON con la información del usuario o un mensaje de error.
     *
     * Ejemplo de respuesta exitosa:
     *
     * @response 200 {
     *   "status": true,
     *   "data": {
     *       "email": "correo@example.com",
     *       "phone": "123456789",
     *       "municipality_name": "NombreMunicipio",
     *       "avatar": "url_avatar",
     *       "username": "nombre_usuario",
     *       "name": "Nombre",
     *       "gender": "Género",
     *       "birth_date": "Fecha de Nacimiento",
     *       "address": "Dirección",
     *       "description": "Descripción del Comercio",
     *       "categories_name": "Nombre de la Categoría",
     *       "schedule": "Horario",
     *       "active": "Estado de Actividad"
     *   }
     * }
     *
     * Ejemplo de respuesta de error:
     *
     * @response 404 {
     *   "status": false,
     *   "error": "Usuario no encontrado"
     * }
     */
    public function show(string $username)
    {
        try {
            $user = User::where("username", $username)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Usuario no encontrado",
                "error" => $th->getMessage(),
            ], 404);
        }


        if ($user->getRoleNames() == "customer") {

            try {

                $customer = Customer::join('users', 'customers.user_id', '=', 'users.id')
                    ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                    ->select(
                        'email',
                        'phone',
                        'municipalities.name AS municipality_name',
                        'avatar',
                        'banner',
                        'username',
                        'users.name',
                        'gender',
                        'birth_date'
                    )
                    ->where('users.username', '=', $username)
                    ->firstOrFail();

                return response()->json([
                    "status" => true,
                    "data" => $customer
                ], 200);
            } catch (QueryException $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500);
            } catch (Exception $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 404);
            }
        } else {

            try {

                $commerce = Commerce::join('users', 'commerces.user_id', '=', 'users.id')
                    ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                    ->join('categories', 'commerces.category_id', '=', 'categories.id')
                    ->select(
                        'email',
                        'phone',
                        'municipalities.name AS municipality_name',
                        'avatar',
                        'banner',
                        'username',
                        'users.name',
                        'address',
                        'commerces.description',
                        'categories.name AS categories_name',
                        'schedule',
                        'commerces.active'
                    )
                    ->where('users.username', '=', $username)
                    ->get();

                $commerce->each(function ($commerce) {

                    $commerceId = Commerce::join('users', 'commerces.user_id', '=', 'users.id')
                    ->select('user_id')
                    ->where('users.username', '=', $commerce->username)
                    ->firstOrFail();

                    $hashtags = Commerce::find($commerceId->user_id)->hashtags->pluck('name')->toArray();
                    $commerce->hashtags = $hashtags;

                });

                return response()->json([
                    "status" => true,
                    "data" => $commerce
                ], 200);
            } catch (QueryException $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500);
            } catch (Exception $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 404);
            }
        }
    }

    /**
     * Actualiza la información de un usuario específico.
     *
     * Comprueba que un usuario por su nombre sea de tipo costumer o commercie
     * para luego poder actualizar los campos respectivos de cada uno
     *
     * @param \Illuminate\Http\Request $request - La solicitud HTTP con los datos de actualización.
     * @param string $username - El nombre de usuario del usuario a actualizar.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON con el resultado de la actualización o un mensaje de error.
     *
     *@response 200 {
     *   "status": true,
     *   "data": "Datos del usuario recien actualizado"
     * }
     * * @response 500 {
     *   "status": false,
     *   "error": "Error en la base de datos"
     * }
     * @response 404 {
     *   "status": false,
     *   "error": "Usuario no encontrado"
     * }
     *
     */


    public function update(Request $request, string $username)
    {
        try {
            // Elimina campos que no queremos actualizar
            $request->request->remove("username");
            $request->request->remove("phone");
            $request->request->remove("email");
            // Busca al usuario por su nombre de usuario
            $user = User::where("username", $username)->firstOrFail();
            // Revisa si el usuario es él mismo el que se va a cambiar
            if (Auth::user()->id != $user->id) {
                return response()->json(["status" => false, "message" => "No autorizado"], 401);
            }
            // Determina el rol del usuario
            if ($user->getRoleNames() == "customer") {
                // Si el usuario es un cliente, actualiza los detalles como cliente
                $customer = Customer::where('user_id', $user->id)->first();
                $customer->fill($request->all());
                $customer->save();
                $updatedUser = $customer->user;
            } else {
                // Si el usuario es un comercio, actualiza los detalles como comercio
                $commerce = Commerce::where('user_id', $user->id)->first();
                $commerce->fill($request->all());
                $commerce->save();
                $updatedUser = $commerce->user;
            }

            // Devuelve una respuesta JSON exitosa con los detalles del usuario actualizados
            return response()->json(["status" => true, "message" => "Usuario actualizado Correctamente:", "data" => $updatedUser], 200);
        } catch (QueryException $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de error de base de datos
            return response()->json(["status" => false, "message" => "Error en la base de datos :", "error" => $e->getMessage()], 500);
        } catch (Exception $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de otra excepción
            return response()->json(["status" => false, "message" => "Usuario no encontrado en la base de datos:", "error" => $e->getMessage()], 404);
        }
    }

    /**
     * Elimina un usuario específico.
     *
     * Si el usuario es un costumer , se elimina de la base de datos directamente
     * pero si es un Commerce , cambia el valor del campo active a false
     * por lo que no se borra de la base de datos
     *
     * @param string $username - El nombre de usuario del usuario a eliminar.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON con el resultado de la eliminación o un mensaje de error.
     *
     *  *@response 200 {
     *   "status": true,
     *   "data": "Usuario eliminado exitosamente"
     * }
     * * @response 500 {
     *   "status": false,
     *   "error": "Error en la base de datos"
     * }
     * @response 404 {
     *   "status": false,
     *   "error": "Usuario no encontrado"
     * }
     *
     */


    public function destroy(string $username)
    {
        try {
            // Busca al usuario por su nombre de usuario
            $user = User::where("username", $username)->firstOrFail();

            // Determina el rol del usuario
            if ($user->getRoleNames() == "customer") {
                // Si el usuario es un cliente, elimina el registro de la tabla 'customers'
                $customer = Customer::where('user_id', $user->id)->first();
                $user->delete();
            } else {
                // Si el usuario es un comercio, actualiza el campo 'active' a false
                $commerce = Commerce::where('user_id', $user->id)->first();
                $commerce->active = false;
                $commerce->save();
            }

            // Devuelve una respuesta JSON exitosa
            return response()->json(["status" => true, "message" => "Usuario eliminado exitosamente"], 200);
        } catch (QueryException $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de error de base de datos
            return response()->json(["status" => false, "message" => "Error en la base de datos :", "error" => $e->getMessage()], 500);
        } catch (Exception $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de otra excepción
            return response()->json(["status" => false, "message" => "Usuario no encontrado en la base de datos:",  "error" => $e->getMessage()], 404);
        }
    }

    public function posts(string $username)
    {
        try {
        } catch (QueryException $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de error de base de datos
            return response()->json(["status" => false, "message" => "Error en la base de datos :", "error" => $e->getMessage()], 500);
        } catch (Exception $e) {
            // Devuelve una respuesta JSON con un mensaje de error en caso de otra excepción
            return response()->json(["status" => false, "message" => "Usuario no encontrado en la base de datos:", "error" => $e->getMessage()], 404);
        }
    }
}
