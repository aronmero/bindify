<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Customer;
use App\Models\Municipality;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{

    /**
     * Almacena un nuevo cliente en la base de datos.
     *
     * Este método crea un nuevo cliente y lo almacena en la base de datos.
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Customer creado.",
     *   "data": {
     *     // Datos del cliente creado
     *   }
     * }
     *
     * @response 400 {
     *   "status": false,
     *   "error": "mensaje_de_error"
     * }
     * @response 409 {
     *   "status": false,
     *   "error": "Error de entrada duplicada:"
     * }
     * @response 500 {
     *   "status": false,
     *   "error": "ErrorException"
     * }
     * * @response 404 {
     *   "status": false,
     *   "error": "ErrorException"
     * }
     *
     * @param  \Illuminate\Http\Request  $request - La solicitud HTTP recibida.
     * @return \Illuminate\Http\JsonResponse - Respuesta JSON que indica si el cliente se creó correctamente o no.
     */
    public function store(Request $request)
    {
        try {

            Municipality::where('id', $request->municipality_id)->firstOrFail();

            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'municipality_id' => $request->municipality_id,
                'avatar' => $request->avatar,
                'username' => $request->username,
                'nombre' => $request->nombre
            ]);

            Customer::create([
                'user_id' => $user->id,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
            ]);

            $data = Customer::join('users', 'customers.user_id', '=', 'users.id')
                ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                ->select(
                    'email',
                    'phone',
                    'municipalities.name AS municipality_name',
                    'avatar',
                    'username',
                    'users.name',
                    'gender',
                    'birth_date'
                )
                ->where('users.id', '=', $user->id)
                ->firstOrFail();

            return response()->json([
                "status" => true,
                "message" => 'Customer creado.',
                "data" => $data
            ], 200);

        } catch (QueryException $e) {

            if ($e->errorInfo[1] === 1062) {
                return response()->json([
                    "status" => false,
                    "error" => "Error de entrada duplicada: " . $e->getMessage()
                ], 409);

            } else {
                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500);
            }

        } catch (ModelNotFoundException $e) {

            return response()->json([
                "status" => false,
                "error" => "Municipio con id: $request->municipality_id no encontrado",
            ], 404);
        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Muestra el cliente especificado por su id
     *
     * Este método devuelve la información del cliente especificado por su ID de usuario.
     *
     * @urlParam id string required El ID del cliente.
     *
     *@response 200 {
     *     "status": true,
     *     "data": {
     *         "email": "correo_electronico",
     *         "phone": "numero_de_telefono",
     *         "municipality_name": "nombre_del_municipio",
     *         "avatar": "avatar",
     *         "username": "nombre_de_usuario",
     *         "name": "nombre",
     *         "gender": "genero",
     *         "birth_date": "fecha_de_nacimiento"
     *     }
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "error": "Cliente no encontrado"
     * }
     *
     * @response 409 {
     *     "status": false,
     *     "error": "Error de entrada duplicada: mensaje_de_error"
     * }
     *
     * @param  string  $id - El ID del cliente.
     * @return \Illuminate\Http\JsonResponse - La respuesta JSON que contiene los datos del cliente o un mensaje de error si no se encuentra el cliente.
     */


    public function show(string $id)
    {

        try {

            $customer = Customer::where('user_id', $id)->firstOrFail();

            $customer = Customer::join('users', 'customers.user_id', '=', 'users.id')
                ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                ->select(
                    'email',
                    'phone',
                    'municipalities.name AS municipality_name',
                    'avatar',
                    'username',
                    'users.name',
                    'gender',
                    'birth_date'
                )
                ->where('users.id', '=', $id)
                ->firstOrFail();



            return response()->json([
                "status" => true,
                "data" => $customer
            ], 200);

        } catch (QueryException $e) {

            // Verificar si la excepción es por entrada duplicada
            if ($e->errorInfo[1] === 1062) {
                return response()->json([
                    "status" => false,
                    "error" => "Error de entrada duplicada: " . $e->getMessage()
                ], 409); // Código de estado HTTP 409: Conflict
            } else {
                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500); // Código de estado HTTP 500: Internal Server Error
            }
        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Actualiza el Cliente especificado por su Id
     *
     * Este método actualiza la información del cliente especificado por su ID de usuario.
     *
     * @urlParam id string required El ID del cliente.
     * @bodyParam email string required El correo electrónico del cliente.
     * @bodyParam password string required La contraseña del cliente.
     * @bodyParam phone string required El número de teléfono del cliente.
     * @bodyParam municipality_id int required El ID del municipio del cliente.
     * @bodyParam avatar string El avatar del cliente.
     * @bodyParam username string required El nombre de usuario del cliente.
     * @bodyParam nombre string required El nombre del cliente.
     * @bodyParam gender string required El género del cliente.
     * @bodyParam birth_date date required La fecha de nacimiento del cliente.
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Customer actualizado.",
     *     "data": {
     *         "email": "correo_electronico",
     *         "phone": "numero_de_telefono",
     *         "municipality_name": "nombre_del_municipio",
     *         "avatar": "avatar",
     *         "username": "nombre_de_usuario",
     *         "name": "nombre",
     *         "gender": "genero",
     *         "birth_date": "fecha_de_nacimiento"
     *     }
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "error": "Customer no encontrado"
     * }
     *
     * @response 409 {
     *     "status": false,
     *     "error": "Error de entrada duplicada: mensaje_de_error"
     * }
     *
     * @response 500 {
     *     "status": false,
     *     "error": "mensaje_de_error"
     * }
     *
     * @param  Request  $request - La solicitud HTTP que contiene los datos del cliente a actualizar.
     * @param  string  $id - El ID del cliente.
     * @return \Illuminate\Http\JsonResponse - La respuesta JSON que indica si el cliente se ha actualizado correctamente o si ha ocurrido un error.
     */
    public function update(Request $request, string $id)
    {

        try {

            $user = User::find($id)->firstOrFail();
            $customer = Customer::where('user_id', $id)->firstOrFail();

            $user->email = $request->email;
            $user->password = $request->password;
            $user->phone = $request->phone;
            $user->municipality_id = $request->municipality_id;
            $user->avatar = $request->avatar;
            $user->username = $request->username;
            $user->nombre = $request->nombre;

            $customer->gender = $request->gender;
            $customer->birth_date = $request->birth_date;

            $user->save();
            $customer->save();

            $data = Customer::join('users', 'customers.user_id', '=', 'users.id')
                ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                ->select(
                    'email',
                    'phone',
                    'municipalities.name AS municipality_name',
                    'avatar',
                    'username',
                    'users.name',
                    'gender',
                    'birth_date'
                )
                ->where('users.id', '=', $user->id)
                ->firstOrFail();

            return response()->json([
                "status" => true,
                "message" => 'Customer actualizado.',
                "data" => $data
            ], 200);

        } catch (QueryException $e) {

            // Verificar si la excepción es por entrada duplicada
            if ($e->errorInfo[1] === 1062) {
                return response()->json([
                    "status" => false,
                    "error" => "Error de entrada duplicada: " . $e->getMessage()
                ], 409); // Código de estado HTTP 409: Conflict
            } else {
                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500); // Código de estado HTTP 500: Internal Server Error
            }
        } catch (ModelNotFoundException $e) {

            return response()->json([
                "status" => false,
                "error" => "Customer no encontrado",
            ], 404);
        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 404);
        }
    }
}
