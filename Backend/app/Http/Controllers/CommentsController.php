<?php

namespace App\Http\Controllers;

use App\Events\ModelCreated;
use App\Http\Requests\StoreCommentsRequest;
use App\Http\Requests\UpdateCommentsRequest;
use App\Models\Comment;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\APIDocumentationController;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:ver comments")->only("show");
        $this->middleware("can:editar comments")->only("store", "update", "destroy");
    }
    /**
     * @OA\Post(
     *     path="/comment",
     *     summary="Store de un nuevo comentario.",
     *     description="Esta función guarda un nuevo comentario en la base de datos.",
     *     tags={"Comments"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="La solicitud HTTP que contiene los datos del comentario.",
     *         @OA\JsonContent(
     *             required={"post_id", "content"},
     *             @OA\Property(property="post_id", type="integer", example=1),
     *             @OA\Property(property="content", type="string", example="Este es un nuevo comentario.")
     *         ),
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=201,
     *         description="Comentario almacenado exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Comentario almacenado exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error al almacenar el comentario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error al almacenar el comentario")
     *         )
     *     )
     * )
     */
    public function store(StoreCommentsRequest $request)
    {

        try {
            // Obtener el usuario autenticado
            $user = auth()->user();

            $post_id = intval(Crypt::decryptString($request->post_id));

            // Crear un nuevo comentario
            $comment = new Comment();
            $comment->user_id = $user->id; // Asignar el ID de usuario
            $comment->post_id = $post_id;
            $comment->content = $request->content;
            $comment->active = true; //comentario activo cuando se crea
            $comment->save();

            event(new ModelCreated($comment));


            return response()->json(['status' => true, 'message' => 'Comentario almacenado exitosamente'], 201);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => "Error al almacenar el comentario: $e"], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/comment/{id}",
     *     summary="Muestra los comentarios relacionados con una publicación.",
     *     description="Esta función obtiene y formatea los comentarios asociados con una publicación específica. Si no se encuentran comentarios para la publicación, devuelve un mensaje de error.",
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="El ID de la publicación para la que se desean obtener los comentarios.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comentarios obtenidos exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(
     *                 property="comentarios",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="encrypted_comment_id"),
     *                     @OA\Property(property="username", type="string", example="nombre_de_usuario"),
     *                     @OA\Property(property="content", type="string", example="contenido_del_comentario"),
     *                     @OA\Property(property="comment_creation", type="string", format="date-time", example="2022-03-15 10:30:00"),
     *                     @OA\Property(property="avatar", type="string", example="avatar_url")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron comentarios para esta publicación.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No se encontraron comentarios para esta publicación")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al obtener los comentarios.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Publicación inexistente")
     *         )
     *     )
     * )
     */

    public function show(string $id)
    {

        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Publicación inexistente',
            ], 500);
        }

        // Obtener todos los comentarios relacionados con la publicación
        $comentarios = Comment::where('post_id', $id)->with('user')->get();

        // Verificar si se encontraron comentarios
        if ($comentarios->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No se encontraron comentarios para esta publicación'], 404);
        }

        // Formatear los datos de los comentarios
        $comentariosFormateados = [];
        foreach ($comentarios as $comentario) {
            $comentarioFormateado = [
                'id' => Crypt::encryptString($comentario->id),
                'username' => $comentario->user->username, // Acceder al nombre del usuario a través de la relación
                'content' => $comentario->content,
                'comment_creation' => $comentario->created_at,
                'avatar' => $comentario->user->avatar,
            ];
            $comentariosFormateados[] = $comentarioFormateado;
        }

        return response()->json(['status' => true, 'comentarios' => $comentariosFormateados], 200);
    }


    /**
     * @OA\Put(
     *     path="/comment/{id}",
     *     summary="Actualizar un comentario existente.",
     *     description="Esta función busca un comentario por su ID y actualiza su contenido con los datos proporcionados en la solicitud.",
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="El ID del comentario que se desea actualizar.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos para actualizar el comentario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="content", type="string", example="Nuevo contenido del comentario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comentario actualizado exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Comentario actualizado exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error al editar el comentario (Algún dato de la solicitud no es válido).",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error al editar el comentario (Algún dato de la solicitud no es válido)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Comentario no actualizado. No tienes permisos sobre este comentario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Comentario no actualizado. No tienes permisos sobre este comentario.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comentario no encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Comentario no encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Comentario inexistente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Comentario inexistente")
     *         )
     *     )
     * )
     */
    public function update(UpdateCommentsRequest $request, string $id)
    {
        try {

            try {
                $id = Crypt::decryptString($id);
            } catch (DecryptException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Comentario inexistente',
                ], 500);
            }

            // Buscar el comentario por su ID
            $comentario = Comment::find($id);

            $user = Auth::user();

            if ($comentario->user->id != $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Comentario no actualizado. No tienes permisos sobre este comentario.',
                ], 403);
            }

            if (!$comentario) {
                // Si no se encuentra el comentario, devolver una respuesta con código de estado 404
                return response()->json(['status' => false, 'message' => 'Comentario no encontrado'], 404);
            }

            // Actualizar el contenido del comentario si se proporciona en la solicitud
            $contenido = $request->input('content'); // Obtener el contenido de la solicitud
            if (!empty($contenido)) {
                $comentario->content = $contenido;
            }

            // Actualizar el comentario con los datos de la solicitud
            $comentario->save();

            // Devolver una respuesta de éxito
            return response()->json(['status' => true, 'message' => 'Comentario actualizado exitosamente'], 200);
        } catch (Exception $e) {
            // Manejar errores y devolver una respuesta de error
            return response()->json(['status' => false, 'message' => 'Error al editar el comentario (Algún dato de la solicitud no es válido)'], 400);
        }
    }



    /**
     * @OA\Delete(
     *     path="/comment/{id}",
     *     summary="Eliminar un comentario existente.",
     *     description="Esta función busca un comentario por su ID y lo elimina de la base de datos.",
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="El ID del comentario que se desea eliminar.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comentario eliminado exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Comentario eliminado exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Comentario no eliminado. No tienes permisos sobre este comentario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Comentario no eliminado. No tienes permisos sobre este comentario.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comentario no encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Comentario no encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error al eliminar el comentario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error al eliminar el comentario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Comentario inexistente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Comentario inexistente")
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
                    'message' => 'Comentario inexistente',
                ], 500);
            }

            // Buscar el comentario por su ID
            $comentario = Comment::find($id);

            $user = Auth::user();

            if ($comentario->user->id != $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Comentario no eliminado. No tienes permisos sobre este comentario.',
                ], 403);
            }

            if (!$comentario) {
                // Si no se encuentra el comentario, devolver una respuesta con código de estado 404
                return response()->json(['status' => false, 'message' => 'Comentario no encontrado'], 404);
            }

            // Eliminar el comentario de la base de datos
            $comentario->notifications()->delete();
            $comentario->delete();

            // Devolver una respuesta de éxito
            return response()->json(['status' => true, 'message' => 'Comentario eliminado exitosamente'], 200);
        } catch (Exception $e) {
            // Manejar errores y devolver una respuesta de error
            return response()->json(['status' => false, 'message' => 'Error al eliminar el comentario'], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/comment/{id}/replies",
     *     summary="Muestra los comentarios que son respuestas a otros comentarios.",
     *     description="Esta función obtiene y formatea los comentarios asociados con un comentario específico. Si no se encuentran comentarios, devuelve un mensaje de error.",
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="El ID del comentario para el que se desean obtener las respuestas.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comentarios obtenidos exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="comentarios", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="string", example="encrypted_comment_id"),
     *                 @OA\Property(property="username", type="string", example="nombre_de_usuario"),
     *                 @OA\Property(property="content", type="string", example="contenido_del_comentario"),
     *                 @OA\Property(property="comment_creation", type="string", example="fecha_creacion_comentario"),
     *                 @OA\Property(property="father_id", type="string", example="encrypted_father_comment_id"),
     *                 @OA\Property(property="avatar", type="string", example="url_avatar_usuario")
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron respuestas para este comentario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No se encontraron respuestas para este comentario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Comentario padre inexistente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Comentario padre inexistente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error al mostrar los comentarios.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error al mostrar los comentarios")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Comentario inexistente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Comentario inexistente")
     *         )
     *     )
     * )
     */
    public function replies(string $id)
    {
        try {

            try {
                $id = Crypt::decryptString($id);
            } catch (DecryptException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Comentario inexistente',
                ], 500);
            }

            // Obtener comentario padre
            $comentario = Comment::findOrFail($id);

            // Obtener todos las respuestas
            $replies = $comentario->replies;

            // Formatear los datos de los comentarios
            $repliesFormatedas = [];
            foreach ($replies as $reply) {
                $replyFormateada = [
                    'id' => Crypt::encryptString($reply->id),
                    'username' => $reply->user->username, // Acceder al nombre del usuario a través de la relación
                    'content' => $reply->content,
                    'comment_creation' => $comentario->created_at,
                    'father_id' => Crypt::encryptString($reply->father_id),
                    'avatar' => $reply->user->avatar,
                ];
                $repliesFormatedas[] = $replyFormateada;
            }

            // Verificar si se encontraron respuestas
            if ($replies->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'No se encontraron respuestas para esta comentario'], 404);
            }

            return response()->json(['status' => true, 'comentarios' => $repliesFormatedas], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Comentario inexistente'], 404);
        } catch (Exception $e) {
            // Manejar errores y devolver una respuesta de error
            return response()->json(['status' => false, 'message' => 'Error al mostrar los comentarios'], 400);
        }
    }
}
