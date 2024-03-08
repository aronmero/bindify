<?php

namespace App\Http\Controllers;

use App\Http\Scripts\Utils;
use App\Models\Commerce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CommercesController extends Controller
{
    /**
     * Constructor de la clase.
     *
     * Este método establece los middlewares de autorización para las acciones del controlador.
     * Se aplica el middleware "ver commerce" solo a la acción "show" y el middleware "editar commerce" a las acciones "store" y "update".
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("can:ver commerces")->only("show");
        $this->middleware("can:editar commerces")->only("store", "update");
    }
    /**
     * Almacena un nuevo recurso creado en el almacenamiento.
     *
     * Este método crea un nuevo usuario y un nuevo comercio asociado a ese usuario.
     * Si se crea exitosamente, devuelve una respuesta JSON con un estado 200 y los datos del comercio creado.
     * Si ocurre un error durante el proceso, devuelve una respuesta JSON con un estado 400 y un mensaje de error.
     *
     * @param \Illuminate\Http\Request $request - La solicitud HTTP que contiene los datos del nuevo comercio.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON que contiene un mensaje de éxito o un mensaje de error.
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Comercio creado",
     *   "data": {
     *     // Datos del comercio creado
     *   }
     * }
     *
     * @response 400 {
     *   "status": false,
     *   "error": "mensaje_de_error"
     * }
     */
    public function store(Request $request)
    {
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'municipality_id' => $request->municipality_id,
                'avatar' => $request->avatar,
                'username' => $request->username,
                'name' => $request->name
            ]);

            $commerce = Commerce::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'description' => $request->description,
                'verification_token_id' => $request->verification_token_id,
                'category_id' => $request->category_id,
                'verificated' => false,
                'schedule' => $request->schedule
            ]);


            return response()->json([
                'status' => true,
                'message' => 'Comercio creado',
                'data' => $commerce
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Muestra el comercio especificado por su ID
     *
     * Este método devuelve los detalles de un comercio específico identificado por su ID de usuario.
     * Si se encuentra el comercio, devuelve una respuesta JSON con los detalles del comercio y un estado 200.
     * Si no se encuentra el comercio, devuelve una respuesta JSON con un mensaje de error y un estado 404.
     *
     * @param string $id - El ID del usuario asociado al comercio que se desea mostrar.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON que contiene los detalles del comercio o un mensaje de error.
     *
     * @response 200 {
     *   "status": true,
     *   "data": {
     *     // Detalles del comercio
     *   }
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "error": "mensaje_de_error"
     * }
     */
    public function show(string $id)
    {
        try {

            $data = DB::table('commerces')
                ->join('users', 'commerces.user_id', '=', 'users.id')
                ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                ->join('categories', 'commerces.category_id', '=', 'categories.id')
                ->select(
                    'email',
                    'phone',
                    'municipalities.name AS municipality_name',
                    'avatar',
                    'username',
                    'name',
                    'address',
                    'description',
                    'categories.name AS categories_name',
                    'schedule',
                    'active'
                )
                ->where('users.id', '=', $id)
                ->get();

            return response()->json([
                'status' => true,
                'data' => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => throw $th,
            ], 404);
        }
    }

    /**
     * Actualiza el comercio especificado por su id de usuario.
     *
     * Este método actualiza los detalles de un comercio identificado por su ID.
     * Si se actualiza correctamente, devuelve una respuesta JSON con un estado 200 y un mensaje de éxito.
     * Si ocurre un error durante el proceso, devuelve una respuesta JSON con un estado 404 y un mensaje de error.
     *
     * @param \Illuminate\Http\Request $request - La solicitud HTTP que contiene los nuevos detalles del comercio.
     * @param string $id - El ID del comercio que se desea actualizar.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON que contiene un mensaje de éxito o un mensaje de error.
     *
     * @response 200 {
     *   "status": true,
     *   "message": "comercio actualizado"
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "error": "mensaje_de_error"
     * }
     */
    public function update(Request $request, string $id)
    {

        // try {
        $user = User::find($id);
        $request->request->remove('verificated');
        $user->update($request->only('phone', 'municipality_id', 'avatar', 'username', 'name'));


        $commerce = Commerce::find($id);
        $commerce->update($request->only('address', 'category_id', 'schedule'));

        return response()->json([
            'status' => true,
            'message' => 'comercio actualizado',
        ], 200);
        // } catch (Throwable $th) {
        //     return response()->json([
        //         'status' => false,
        //         'error' => $th->getMessage(),
        //     ], 404);
        // }

    }

}
