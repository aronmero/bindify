<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentsRequest;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Exception;

class CommentsController extends Controller
{

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
        // Validar los datos de la solicitud
        /*/ $request->validate([
            'post_id' => 'required|integer', // ID de la publicación a la que pertenece el comentario
            'user_id' => 'required|integer', // ID del usuario que realiza el comentario
            'content' => 'required|string', // Contenido del comentario
            'comment_id' => 'nullable|integer', // ID del comentario padre en caso de que exista
       ]);
       */


        try {
            // Crear un nuevo comentario
            $comment = new Comment();
            $comment->user_id = $request->user_id;
            $comment->post_id = $request->post_id;
            $comment->content = $request->content;
            $comment->comment_id = $request->comment_id;  // Asignar el comentario padre
            $comment->active = true; //comentario activo cuando se crea
            $comment->save();

            return response()->json(['status' => true, 'message' => 'Comentario almacenado exitosamente'], 201);
        } catch (\Exception $e) {
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
                'username' => $comentario->user->username, // Acceder al nombre del usuario a través de la relación
                'content' => $comentario->content,
                'comment_id' => $comentario->id,
                'avatar' => $comentario->user->avatar,
                'user_id' => $comentario->user->id

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
     * @response 404 {
     *   "status": false,
     *   "message": "Comentario no encontrado"
     * }
     */
    public function update(Request $request, int $id)
    {
        try {
            // Buscar el comentario por su ID
            $comentario = Comment::find($id);

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
            // Buscar el comentario por su ID
            $comentario = Comment::find($id);

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
}
