<?php

namespace App\Http\Controllers;

use App\Events\ModelCreated;
use App\Http\Requests\StoreReviewsRequest;
use App\Http\Requests\UpdateReviewsRequest;
use App\Models\User;
use App\Models\Review;
use App\Http\Scripts\Utils;
use App\Models\Commerce;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ReviewsController extends Controller
{
    /**
     * @OA\Post(
     *     path="/review",
     *     summary="Almacena una nueva review.",
     *     description="Este método crea una nueva review utilizando los datos proporcionados en la solicitud. Si la review se crea con éxito, devuelve una respuesta JSON con un mensaje de éxito y los detalles de la review creada. Si ocurre algún error durante el proceso de creación de la review, devuelve una respuesta JSON con un mensaje de error.",
     *     operationId="storeReview",
     *     tags={"Reviews"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\RequestBody(
     *         required=true,
     *         description="La solicitud HTTP que contiene los datos de la review a crear.",
     *         @OA\JsonContent(
     *             required={"commerce_username", "comment", "note"},
     *             @OA\Property(property="commerce_username", type="string", example="nombre_usuario_comercio"),
     *             @OA\Property(property="comment", type="string", example="Contenido_del_comentario"),
     *             @OA\Property(property="note", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Review creada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Review creada"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="commerce_id", type="string", example="ID_del_comercio"),
     *                 @OA\Property(property="content", type="string", example="Contenido_del_comentario"),
     *                 @OA\Property(property="note", type="integer", example=5)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Usuario inexistente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Usuario inexistente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="El usuario $request->commerce_username no es un comercio",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="El usuario $request->commerce_username no es un comercio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al crear la review: mensaje_de_error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error al crear la review: mensaje_de_error")
     *         )
     *     )
     * )
     */
    public function store(StoreReviewsRequest $request)
    {
        try {


            try {
                $id = User::where('username', '=', $request->commerce_username)->firstOrFail()->id;
            } catch (ModelNotFoundException $e) {
                return response()->json(['status' => false, 'message' => 'Usuario inexistente'], 404);
            }
            try {
                Commerce::where('user_id', '=', $id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return response()->json(['status' => false, 'message' => "El usuario $request->commerce_username no es un comercio"], 404);
            }

            // Crear una nueva Review
            $review = new Review([
                'user_id' => auth()->user()->id,
                'commerce_id' => $id,
                'comment' => $request->comment,
                'note' => $request->note,
            ]);

            $review->save();

            Utils::AVG_Reviews($id);

            event(new ModelCreated($review));

            return response()->json([
                'status' => true,
                'message' => 'Review creada',
                'data' => [
                    'commerce_id' => $review->commerce_id,
                    'content' => $review->comment,
                    'note' => $review->note,
                    'id' => $review->id,
                    'id' => Crypt::encryptString($review->id),
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error al crear la review: No puedes tener dos reviews de un mismo sitio '], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/review/{username}",
     *     summary="Muestra las reviews relacionadas con un comercio.",
     *     description="Esta función obtiene y formatea las reviews asociadas con un comercio específico. Si no se encuentran reviews para el comercio, el usuario no existe o no es un comercio devuelve un mensaje de error.",
     *     operationId="showReviews",
     *     tags={"Reviews"},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         description="El username del comercio para el que se desean obtener las reviews.",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta JSON que contiene las reviews formateadas.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="reviews", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="string", example="identificador_de_la_review"),
     *                     @OA\Property(property="username", type="string", example="nombre_de_usuario"),
     *                     @OA\Property(property="avatarUsuario", type="string", example="avatar_del_usuario"),
     *                     @OA\Property(property="commerce_username", type="string", example="nombre_de_usuario_del_comercio"),
     *                     @OA\Property(property="avatarComercio", type="string", example="avatar_del_comercio"),
     *                     @OA\Property(property="comment", type="string", example="comentario_de_la_revision"),
     *                     @OA\Property(property="note", type="integer", example=5)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No se encontraron reviews para este comercio",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No se encontraron reviews para el comercio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Usuario inexistente o no es un comercio",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Usuario inexistente o no es un comercio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reviews no encontradas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Reviews no encontradas")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al mostrar las reviews",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Error al mostrar las reviews")
     *         )
     *     )
     * )
     */
    public function show(string $username)
    {
        // Obtener todas las reviews para el comercio con el username dado

        try {

            $user = User::where('username', $username)->first();

            if (!$user) {
                return response()->json(['status' => false, 'message' => "Usuario inexistente."], 403);
            } elseif (!(Commerce::where('commerces.user_id', '=', $user->id)->first())) {
                $userRol = $user->getRoleNames()[0];
                return response()->json(['status' => false, 'message' => "Este usuario no es un comercio.", 'rol' => $userRol], 403);
            }

            $reviews = Review::where('commerce_id', $user->id)->get();

            // Crear un array para almacenar los datos de las reviews
            $reviewsArray = [];
            if ($reviews->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'No se encontraron reviews para el comercio',], 401);
            }

            // Iterar sobre cada reviews
            foreach ($reviews as $review) {
                // Obtener los datos necesarios para cada reviews
                $reviewData = [
                    'id' => Crypt::encryptString($review->id),
                    'username' => $review->user->username,
                    'avatarUsuario' => $review->user->avatar,
                    'commerce_username' => $review->commerce->username, // Obtener el nombre de usuario del comercio
                    'avatarComercio' => $review->commerce->avatar, // Obtener el avatar del comercio
                    'comment' => $review->comment,
                    'note' => $review->note,
                ];

                // Agregar los datos de la reviews al array
                $reviewsArray[] = $reviewData;
            }

            // Verificar si se encontraron reviews para el comercio
            if (count($reviewsArray) > 0) {
                // Devolver respuesta con las reviews formateadas
                return response()->json(['status' => true, 'reviews' => $reviewsArray,], 200);
            }


            return response()->json(['status' => false, 'message' => 'Reviews no encontradas',], 404);
        } catch (\Exception $e) {
            // En caso de excepción, devolver una respuesta de error
            return response()->json(['status' => false, 'error' => 'Error al mostrar las reviews: ' . $e->getMessage(),], 500);
        }
    }



    /**
     * @OA\Put(
     *     path="/reviews/{id}",
     *     summary="Actualiza una review existente.",
     *     description="Este método busca una review por su ID y actualiza sus datos con los proporcionados en la solicitud. Si la review se actualiza con éxito, devuelve una respuesta JSON con un mensaje de éxito. Si la review no se encuentra, devuelve una respuesta JSON con un mensaje de error. Si ocurre algún error durante el proceso de actualización de la review, devuelve una respuesta JSON con un mensaje de error.",
     *     operationId="updateReview",
     *     tags={"Reviews"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="El ID de la review a actualizar.",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos actualizados de la review.",
     *         @OA\JsonContent(
     *             required={"comment", "note"},
     *             @OA\Property(property="comment", type="string", example="Nuevo comentario"),
     *             @OA\Property(property="note", type="integer", example=4)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Review actualizada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Review actualizada exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="La review no existe",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="La review no existe")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al actualizar la review",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error al actualizar la review: mensaje_de_error")
     *         )
     *     )
     * )
     */
    public function update(UpdateReviewsRequest $request, string $id)
    {
        try {

            try {
                $id = Crypt::decryptString($id);
            } catch (DecryptException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Review inexistente',
                ], 500);
            }

            $user = Auth::user();
            // Buscar la review por su ID
            $review = Review::find($id);

            if ($review->user->id != $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Review no actualizada. No tienes permisos sobre esta review.',
                ], 403);
            }

            // Verificar si la review existe
            if (!$review) {
                return response()->json(['status' => false, 'message' => 'La review no existe',], 404);
            }

            // Guardar el commerce_id antes de actualizar la revisión
            $commerce_id = $review->commerce_id;

            // Actualizar la review con los datos proporcionados en la solicitud
            $review->update([
                'comment' => $request->comment,
                'note' => $request->note,
            ]);

            // Calcular y actualizar la puntuación media
            Utils::AVG_Reviews($commerce_id);

            // Devolver una respuesta de éxito
            return response()->json([
                'status' => true,
                'message' => 'Review actualizada exitosamente',
            ], 200);
        } catch (\Exception $e) {
            // En caso de excepción, devolver una respuesta de error
            return response()->json(['status' => false, 'message' => 'Error al actualizar la review: ' . $e->getMessage(),], 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/reviews/{id}",
     *     summary="Elimina una review.",
     *     description="Este método busca una review por su ID y la elimina de la base de datos. Si la review se elimina con éxito, devuelve una respuesta JSON con un mensaje de éxito. Si la review no se encuentra, devuelve una respuesta JSON con un mensaje de error. Si ocurre algún error durante el proceso de eliminación de la review, devuelve una respuesta JSON con un mensaje de error.",
     *     operationId="deleteReview",
     *     tags={"Reviews"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="El ID de la review a eliminar.",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Review eliminada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Review eliminada exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="La review no existe",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="La review no existe")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al eliminar la review",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error al eliminar la review: mensaje_de_error")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {

            try {
                $id = Crypt::decryptString($id);
            } catch (DecryptException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Review inexistente',
                ], 500);
            }

            $user = Auth::user();
            // Buscar la review por su ID
            $review = Review::find($id);

            if ($review->user->id != $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Review no eliminada. No tienes permisos sobre esta review.',
                ], 403);
            }

            // Verificar si la review existe
            if (!$review) {
                return response()->json(['status' => false, 'message' => 'La review no existe',], 404);
            }

            // Guardar el commerce_id antes de eliminar la revisión
            $commerce_id = $review->commerce_id;

            //Guardar la review en la tabla deleted_reviews

            $now = Carbon::now();
            $nowFormatted = $now->format('Y-m-d H:i:s');

            $reviewData = [
                'id' => $review->id,
                'user_id' => $review->user_id,
                'commerce_id' => $review->commerce_id,
                'comment' => $review->comment,
                'note' => $review->note,
                'deleted_date' => $nowFormatted
            ];

            DB::table('deleted_reviews')->insert($reviewData);

            $review->notifications()->delete();

            // Eliminar la review
            $review->delete();

            Utils::AVG_Reviews($commerce_id);

            // Devolver una respuesta de éxito
            return response()->json([
                'status' => true,
                'message' => 'review eliminada exitosamente',
            ], 200);
        } catch (\Exception $e) {
            // En caso de excepción, devolver una respuesta de error
            return response()->json(['status' => false, 'message' => 'Error al eliminar la review: ' . $e->getMessage(),], 500);
        }
    }
}
