<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentsRequest;
use App\Http\Requests\UpdateCommentsRequest;
use App\Models\Comment;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:ver comments")->only("show");
        $this->middleware("can:editar comments")->only("store", "update", "destroy");
    }
    /**
     * Store de un nuevo comentario.
     *
     * Esta función guarda un nuevo comentario en la base de datos.
     *
     * @param \Illuminate\Http\Request $request - La solicitud HTTP que contiene los datos del comentario.
     *
     * @return \Illuminate\Http\JsonResponse - Respuesta JSON que indica el éxito del almacenamiento del comentario.
     *
     * @response 201 {
     *   "status": true,
     *   "message": "Comentario almacenado exitosamente"
     * }
     *
     * @response 400 {
     *   "status": false,
     *   "message": "Error al almacenar el comentario"
     * }
     */
    public function store(StoreCommentsRequest $request)
    {

        try {
            // Obtener el usuario autenticado
            $user = auth()->user();

            $request->post_id = Crypt::decryptString($request->post_id);

            // Crear un nuevo comentario
            $comment = new Comment();
            $comment->user_id = $user->id; // Asignar el ID de usuario
            $comment->post_id = $request->post_id;
            
            $comment->content = $request->content;
            $comment->active = true; //comentario activo cuando se crea
            $comment->save();


            return response()->json(['status' => true, 'message' => 'Comentario almacenado exitosamente'], 201);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error al almacenar el comentario'], 400);
        }
    }



    /**
     * Muestra los comentarios relacionados con una publicación.
     *
     * Esta función obtiene y formatea los comentarios asociados con una publicación específica.
     * Si no se encuentran comentarios para la publicación, devuelve un mensaje de error.
     *
     * @param string $id - El ID de la publicación para la que se desean obtener los comentarios.
     *
     * @return \Illuminate\Http\JsonResponse - Respuesta JSON que contiene los comentarios formateados.
     *
     * @response 200 {
     *   "status": true,
     *   "comentarios": [
     *     {
     *       "username": "nombre_de_usuario",
     *       "content": "contenido_del_comentario",
     *       "comment_id": "identificador_del_comentario"
     *     },
     *     ...
     *   ]
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "message": "No se encontraron comentarios para esta publicación"
     * }
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
     * Actualizar un comentario existente.
     *
     * Esta función busca un comentario por su ID y actualiza su contenido con los datos proporcionados en la solicitud.
     *
     * @param \Illuminate\Http\Request $request - La solicitud HTTP que contiene los datos para actualizar el comentario.
     * @param int $id - El ID del comentario que se desea actualizar.
     *
     * @return \Illuminate\Http\JsonResponse - Respuesta JSON que indica el éxito o el fracaso de la actualización del comentario.
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Comentario actualizado exitosamente"
     * }
     *
     * @response 400 {
     *   "status": false,
     *   "message": "Error al editar el comentario (Algún dato de la solicitud no es válido)"
     * }
     *
     * @response 403 {
     *   "status": false,
     *   "message": "Comentario no actualizado. No tienes permisos sobre este comentario"
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "message": "Comentario no encontrado"
     * }
     */
    public function update(UpdateCommentsRequest $request, int $id)
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
     * Elimina un comentario existente.
     *
     * Esta función busca un comentario por su ID y lo elimina de la base de datos.
     *
     * @param string $id - El ID del comentario que se desea eliminar.
     *
     * @return \Illuminate\Http\JsonResponse - Respuesta JSON que indica el éxito o el fracaso de la eliminación del comentario.
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Comentario eliminado exitosamente"
     * }
     *
     * @response 403 {
     *   "status": false,
     *   "message": "Comentario no eliminado. No tienes permisos sobre este comentario"
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "message": "Comentario no encontrado"
     * }
     *
     * @response 400 {
     *   "status": false,
     *   "message": "Error al eliminar el comentario"
     * }
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
            $comentario->delete();

            // Devolver una respuesta de éxito
            return response()->json(['status' => true, 'message' => 'Comentario eliminado exitosamente'], 200);
        } catch (Exception $e) {
            // Manejar errores y devolver una respuesta de error
            return response()->json(['status' => false, 'message' => 'Error al eliminar el comentario'], 400);
        }
    }

    /**
     * Muestra los comentarios que son respuestas a otros comentarios.
     *
     * Esta función obtiene y formatea los comentarios asociados con un comentario específico.
     * Si no se encuentran comentarios, devuelve un mensaje de error.
     *
     * @param string $id - El ID del comentario para la que se desean obtener las respuestas.
     *
     * @return \Illuminate\Http\JsonResponse - Respuesta JSON que contiene los comentarios formateados.
     *
     * @response 200 {
     *   "status": true,
     *   "comentarios": [
     *     {
     *       "username": "nombre_de_usuario",
     *       "content": "contenido_del_comentario",
     *       "comment_id": "identificador_del_comentario"
     *     },
     *     ...
     *   ]
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "message": "No se encontraron respuestas para esta comentario"
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "message": "Comentario padre inexistente"
     * }
     *
     * @response 400 {
     *   "status": false,
     *   "message": "Error al mostrar los comentarios"
     * }
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
                    'father_id' => ($reply->father_id),
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
