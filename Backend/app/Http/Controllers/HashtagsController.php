<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHashtagRequest;
use Illuminate\Support\Facades\DB;

class HashtagsController extends Controller
{
   /**
 * @swagger
 * /api/hashtags:
 *   get:
 *     summary: Muestra todos los hashtags disponibles.
 *     description: >
 *       Este método devuelve una lista de todos los hashtags disponibles en el sistema.
 *     responses:
 *       200:
 *         description: Lista de hashtags obtenida exitosamente.
 *         content:
 *           application/json:
 *             example:
 *               status: true
 *               data:
 *                 - name: NombreHashtag1
 *                 - name: NombreHashtag2
 *                 # ...
 *       404:
 *         description: Error al obtener la lista de hashtags.
 *         content:
 *           application/json:
 *             example:
 *               status: false
 *               message: mensaje_de_error
 */
    public function index()
    {
        try {

            $data = Hashtag::select('name')->get();

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
 * @swagger
 * /api/hashtags:
 *   post:
 *     summary: Almacena un nuevo hashtag.
 *     description: >
 *       Este método almacena un nuevo hashtag con la información proporcionada.
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               name:
 *                 type: string
 *     responses:
 *       200:
 *         description: Hashtag creado exitosamente.
 *         content:
 *           application/json:
 *             example:
 *               status: true
 *               message: Hashtag creado exitosamente.
 *       400:
 *         description: Error al crear el hashtag debido a que ya existe.
 *         content:
 *           application/json:
 *             example:
 *               status: false
 *               message: el hashtag ya existe
 *       404:
 *         description: Error al crear el hashtag.
 *         content:
 *           application/json:
 *             example:
 *               status: false
 *               message: mensaje_de_error
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
 * @swagger
 * /api/hashtags/populares:
 *   get:
 *     summary: Obtiene los 8 hashtags más populares.
 *     description: >
 *       Este método busca los 8 hashtags más usados por los commerces y los posts.
 *     parameters:
 *       - in: query
 *         name: type
 *         schema:
 *           type: string
 *         required: true
 *         description: Tipo de publicación (Posts o Commerces).
 *     responses:
 *       200:
 *         description: Lista de hashtags populares obtenida exitosamente.
 *         content:
 *           application/json:
 *             example:
 *               status: true
 *               data:
 *                 - name: NombreHashtag1
 *                   hashtag_count: 10
 *                 - name: NombreHashtag2
 *                   hashtag_count: 8
 *                 # ...
 *       404:
 *         description: Error al obtener la lista de hashtags populares.
 *         content:
 *           application/json:
 *             example:
 *               status: false
 *               message: mensaje_de_error
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
