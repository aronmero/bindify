<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;

class HashtagsController extends Controller
{
    /**
     * Muestra todos los hashtags disponibles.
     *
     * Este método devuelve una lista de todos los hashtags disponibles en el sistema.
     *
     * @response 200 {
     *     "status": true,
     *     "data": [
     *         {
     *             // Datos del hashtag
     *         },
     *         ...
     *     ]
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "message": "mensaje_de_error"
     * }
     */
    public function index()
    {
        try {

            $data = Hashtag::all();

            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Almacena un nuevo hashtag.
     *
     * Este método almacena un nuevo hashtag con la información proporcionada.
     *
     * @bodyParam name string required El nombre del hashtag.
     *
     * @response 200 {
     *     "status": true,
     *     "data": id_del_hashtag_creado
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "message": "mensaje_de_error"
     * }
     */

    public function store(Request $request)
    {
        try {
            $data = Hashtag::create($request->all());

            return response()->json([
                'status' => true,
                'data' => $data->id
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }
}
