<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHashtagRequest;
use Illuminate\Support\Facades\DB;

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
     * @response 400 {
     *      "status": false,
     *     "message": "el hashtag ya existe"
     * }
     */

    public function store(StoreHashtagRequest $request)
    {
        // Verificar si el hashtag ya existe en la base de datos
        $existingHashtag = Hashtag::where('name', $request->name)->first();

        // Si el hashtag ya existe, devolver una respuesta con un mensaje de error
        if ($existingHashtag) {
            return response()->json([
                'status' => false,
                'message' => 'El hashtag ya existe en la base de datos.'
            ], 400);
        }

        // Si el hashtag no existe, intentar guardarlo en la base de datos
        $hashtag = Hashtag::create([
            'name' => $request->name
        ]);

        // Devolver una respuesta de éxito si se guardó correctamente
        return response()->json([
            'status' => true,
            'message' => 'Hashtag creado exitosamente.'
        ], 200);
    }

    /**
     * Almacena un nuevo hashtag.
     *
     * Este método busca los 8 posts mas usados por los commerces y los posts.
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
     * @response 400 {
     *      "status": false,
     *     "message": "el hashtag ya existe"
     * }
     */
    public function populares(Request $request)
    {
        try {

            if ($request->type == 'Posts') {

            $hashtags = Hashtag::join('posts-hashtags', 'posts-hashtags.hashtag_id', '=', 'hashtags.id')
                ->select(
                    'hashtags.name',
                    DB::raw('count(`posts-hashtags`.hashtag_id) as hashtag_count')
                )
                ->orderBy('hashtag_count', 'desc')
                ->groupBy('hashtags.name')
                ->limit(8)
                ->get();

            return response()->json([
                'status' => true,
                'data' => $hashtags
            ], 200);
        }

        $hashtags = Hashtag::join('commerces-hashtags', 'commerces-hashtags.hashtag_id', '=', 'hashtags.id')
                ->select(
                    'hashtags.name',
                    DB::raw('count(`commerces-hashtags`.hashtag_id) as hashtag_count')
                )
                ->orderBy('hashtag_count', 'desc')
                ->groupBy('hashtags.name')
                ->limit(8)
                ->get();

            return response()->json([
                'status' => true,
                'data' => $hashtags
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

}
