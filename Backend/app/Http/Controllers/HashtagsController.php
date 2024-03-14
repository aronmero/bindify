<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHashtagRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\APIDocumentationController;

class HashtagsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/hashtags",
     *     summary="Muestra todos los hashtags disponibles",
     *     tags={"Hashtags"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de hashtags obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="hashtag1")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron hashtags",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/hashtags",
     *     summary="Almacena un nuevo hashtag",
     *     tags={"Hashtags"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", description="El nombre del hashtag")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hashtag creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Error al almacenar el hashtag",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="El hashtag ya existe",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/hashtags/populares",
     *     summary="Obtiene los hashtags más populares",
     *     tags={"Hashtags"},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", enum={"Posts", "Commerces"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de hashtags populares obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="name", type="string", example="hashtag1")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Error al obtener los hashtags populares",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
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
