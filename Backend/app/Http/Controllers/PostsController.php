<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostsRequest;
use App\Http\Requests\UpdatePostsRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostsController extends Controller
{

    /**
     * Muestra una lista de publicaciones para el usuario sin ningún tipo de seguidos.
     *
     * Este método devuelve una lista de publicaciones para el usuario autenticado sin restricciones.
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": true,
     *     "data": [
     *         {
     *             "post_id": "ID_de_la_publicación",
     *             "image": "imagen_de_la_publicación",
     *             "title": "título_de_la_publicación",
     *             "description": "descripción_de_la_publicación",
     *             "name": "nombre_del_tipo_de_publicación",
     *             "start_date": "fecha_de_inicio_de_la_publicación",
     *             "end_date": "fecha_de_finalización_de_la_publicación",
     *             "created_at": "fecha_de_creación_de_la_publicación",
     *             "username": "nombre_de_usuario",
     *             "user_id": "ID_del_usuario",
     *             "avatar": "avatar_del_usuario"
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

    public function home_calendario()
    {
        try {
            $user = Auth::user();

            $listado = Post::join('users-posts', 'users-posts.post_id', '=', 'posts.id')
                ->join('users', 'users.id', '=', 'users-posts.user_id')
                ->join('post_types', 'post_types.id', '=', 'posts.post_type_id')
                ->join('commerces', 'users.id', 'commerces.user_id')
                ->join('municipalities', 'users.municipality_id', 'municipalities.id')
                ->select(
                    'posts.id AS post_id',
                    'posts.image',
                    'posts.title',
                    'posts.description',
                    'posts.description',
                    'post_types.name',
                    'posts.start_date',
                    'posts.end_date',
                    'posts.created_at',
                    'users.username',
                    'users.id AS user_id',
                    'users.avatar',
                    'commerces.avg as avg',
                    'municipalities.name as municipality'
                )
                ->where('posts.active', '=', true)
                ->orderBy('posts.created_at', 'desc')
                ->get();



            $listado->each(function ($post) {
                $commentsCount = Comment::where('post_id', $post->post_id)->count();
                $post->comment_count = $commentsCount;
                $post->hashtags = Post::find($post->post_id)->hashtags->pluck('name')->toArray();
                $user = User::where('username', $post->username)->first();
                $post->userRol = $user->getRoleNames()[0];
            });

            return response()->json([
                'status' => true,
                'data' => $listado,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Muestra una lista de publicaciones para el usuario sin ningún tipo de seguidos.
     *
     * Este método devuelve una lista de publicaciones para el usuario autenticado sin restricciones.
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": true,
     *     "data": [
     *         {
     *             "post_id": "ID_de_la_publicación",
     *             "image": "imagen_de_la_publicación",
     *             "title": "título_de_la_publicación",
     *             "description": "descripción_de_la_publicación",
     *             "name": "nombre_del_tipo_de_publicación",
     *             "start_date": "fecha_de_inicio_de_la_publicación",
     *             "end_date": "fecha_de_finalización_de_la_publicación",
     *             "created_at": "fecha_de_creación_de_la_publicación",
     *             "username": "nombre_de_usuario",
     *             "user_id": "ID_del_usuario",
     *             "avatar": "avatar_del_usuario"
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

    public function home_todos()
    {
        try {
            $user = Auth::user();

            $listado = Post::join('users-posts', 'users-posts.post_id', '=', 'posts.id')
                ->join('users', 'users.id', '=', 'users-posts.user_id')
                ->join('post_types', 'post_types.id', '=', 'posts.post_type_id')
                ->join('commerces', 'users.id', 'commerces.user_id')
                ->select(
                    'posts.id AS post_id',
                    'posts.image',
                    'posts.title',
                    'posts.description',
                    'post_types.name',
                    'posts.start_date',
                    'posts.end_date',
                    'posts.created_at',
                    'users.username',
                    'users.id AS user_id',
                    'users.avatar',
                    'commerces.avg as avg',
                )
                ->where('posts.active', '=', true)
                ->orderBy('posts.start_date', 'desc')
                ->get();



            $listado->each(function ($post) {
                $commentsCount = Comment::where('post_id', $post->post_id)->count();
                $post->comment_count = $commentsCount;
                $post->hashtags = Post::find($post->post_id)->hashtags->pluck('name')->toArray();
                $post->post_id = Crypt::encryptString($post->post_id);
                $user = User::where('username', $post->username)->first();
                $post->userRol = $user->getRoleNames()[0];
            });

            return response()->json([
                'status' => true,
                'data' => $listado,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Muestra una lista de publicaciones para el usuario actual.
     *
     * Este método devuelve una lista de publicaciones para el usuario autenticado.
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": true,
     *     "data": [
     *         {
     *             "post_id": "ID_de_la_publicación",
     *             "image": "imagen_de_la_publicación",
     *             "title": "título_de_la_publicación",
     *             "description": "descripción_de_la_publicación",
     *             "name": "nombre_del_tipo_de_publicación",
     *             "start_date": "fecha_de_inicio_de_la_publicación",
     *             "end_date": "fecha_de_finalización_de_la_publicación",
     *             "created_at": "fecha_de_creación_de_la_publicación",
     *             "username": "nombre_de_usuario",
     *             "user_id": "ID_del_usuario",
     *             "avatar": "avatar_del_usuario"
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

    public function home()
    {
        try {
            $user = Auth::user();

            $follows = $user->follows;
            $ids = [];

            foreach ($follows as $seguido) {
                $ids[] = $seguido->id;
            }

            $listado = Post::join('users-posts', 'users-posts.post_id', '=', 'posts.id')
                ->join('users', 'users.id', '=', 'users-posts.user_id')
                ->join('post_types', 'post_types.id', '=', 'posts.post_type_id')
                ->select(
                    'posts.id AS post_id',
                    'posts.image',
                    'posts.title',
                    'posts.description',
                    'post_types.name',
                    'posts.start_date',
                    'posts.end_date',
                    'posts.created_at',
                    'users.username',
                    'users.id AS user_id',
                    'users.avatar'
                )
                ->whereIn('users-posts.user_id', $ids)
                ->where('posts.active', '=', true)
                ->orderBy('posts.start_date', 'desc')
                ->get();

            $listado->each(function ($post) {
                $commentsCount = Comment::where('post_id', $post->post_id)->count();
                $post->comment_count = $commentsCount;
                $post->hashtags = Post::find($post->post_id)->hashtags->pluck('name')->toArray();
                $post->post_id = Crypt::encryptString($post->post_id);
                $user = User::where('username', $post->username)->first();
                $post->userRol = $user->getRoleNames()[0];
            });

            return response()->json([
                'status' => true,
                'data' => $listado,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Crea una nueva publicación en la plataforma.
     *
     * Este método permite al usuario autenticado crear una nueva publicación en la plataforma,
     * con los datos proporcionados en la solicitud.
     *
     * @authenticated
     *
     * @param  \App\Http\Requests\StorePostsRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Post creado",
     *     "data": {
     *         "post_id": "ID_de_la_publicación",
     *         "image": "imagen_de_la_publicación",
     *         "title": "título_de_la_publicación",
     *         "description": "descripción_de_la_publicación",
     *         "post_type_name": "nombre_del_tipo_de_publicación",
     *         "start_date": "fecha_de_inicio_de_la_publicación",
     *         "end_date": "fecha_de_finalización_de_la_publicación",
     *         "active": true,
     *         "ubicacion": "ubicacion_de_la_publicación",
     *         "fecha_creacion": "fecha_de_creación_de_la_publicación",
     *         "hashtags": ["hashtag1", "hashtag2", ...]
     *     }
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "message": "mensaje_de_error"
     * }
     */
    public function store(StorePostsRequest $request)
    {
        try {
            $user = Auth::user();

            $post = Post::create([
                'image' => $request->image,
                'title' => $request->title,
                'description' => $request->description,
                'post_type_id' => $request->post_type_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'active' => true,
            ]);

            try {
                $post->users()->attach($user->id);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage(),
                ], 404);
            }


            $postData = [
                'post_id' => $post->id = Crypt::encryptString($post->id),
                'image' => $post->image,
                'title' => $post->title,
                'description' => $post->description,
                'post_type_name' => optional($post->post_type)->name,
                'start_date' => $post->start_date,
                'end_date' => $post->end_date,
                'active' => $post->active,
                'ubicacion' => $post->ubicacion,
                'fecha_creacion' => $post->created_at,
                'hastags' => $post->hashtags->pluck('name')
            ];
            return response()->json(['status' => true, 'message' => 'Post creado', 'data' => $postData], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage(),], 404);
        }
    }

    /**
     * Muestra los detalles de una publicación específica junto con los comentarios y usuarios asociados.
     *
     * Este método recupera información detallada sobre una publicación específica, incluyendo su imagen,
     * título, descripción, tipo, fechas, estado, ubicación, fecha de creación y hashtags asociados.
     * Además, obtiene hasta 5 comentarios asociados con la publicación, junto con los nombres de usuario,
     * avatares e IDs de los comentaristas. También recupera información sobre los usuarios que son propietarios
     * de la publicación, incluyendo sus nombres, nombres de usuario, avatares e IDs.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     * "status": true,
     * "data": {
     * "post": {
     * "image": "imagen_de_la_publicación",
     * "title": "título_de_la_publicación",
     * "description": "descripción_de_la_publicación",
     * "post_type_name": "nombre_del_tipo_de_publicación",
     * "start_date": "fecha_de_inicio_de_la_publicación",
     * "end_date": "fecha_de_finalización_de_la_publicación",
     * "active": true,
     * "ubicacion": "ubicación_de_la_publicación",
     * "fecha_creacion": "fecha_de_creación_de_la_publicación",
     * "hashtags": ["hashtag1", "hashtag2", ...]
     * },
     * "users": [
     * {
     * "name": "nombre_del_usuario",
     * "username": "nombre_de_usuario",
     * "avatar": "avatar_del_usuario",
     * "id": "ID_del_usuario"
     * },
     * ...
     * ],
     * "comments": [
     * {
     * "username": "nombre_de_usuario",
     * "content": "contenido_del_comentario",
     * "comment_id": "ID_del_comentario",
     * "avatar": "avatar_del_usuario",
     * "user_id": "ID_del_usuario"
     * },
     * ...
     * ]
     * }
     * }
     *
     * @response 404 {
     * "status": false,
     * "message": "mensaje_de_error"
     * }
     */
    public function show(string $id)
    {
        try {

             try {
                 $id = Crypt::decryptString($id);
             } catch (DecryptException $e) {
                 return response()->json([
                     'status' => false,
                     'message' => 'Post inexistente',
                 ], 500);
             }

            // Obtener el post
            $post = Post::with('users')->findOrFail($id);

            foreach ($post->users as $key) {
                $user = User::where('username', $key->username)->first();
                $post->userRol = $user->getRoleNames()[0];
            }

            // Obtener datos del post
            $postData = [
                'image' => $post->image,
                'title' => $post->title,
                'description' => $post->description,
                'post_type_name' => optional($post->post_type)->name,
                'start_date' => $post->start_date,
                'end_date' => $post->end_date,
                'active' => $post->active,
                'ubicacion' => $post->ubicacion,
                'fecha_creacion' => $post->created_at,
                'hastags' => $post->hashtags->pluck('name'),
                'userRol' => $post->userRol
            ];



            // Obtener los 5 primeros comentarios del post
            $comments = Comment::where('post_id', $id)->with('user')->take(5)->get();

            // Formatear los datos de los comentarios
            $formattedComments = [];
            foreach ($comments as $comment) {
                $formattedComment = [
                    'username' => $comment->user->username,
                    'content' => $comment->content,
                    //'comment_id' => $comment->id,
                    'comment_id' => Crypt::encryptString($comment->id),
                    'avatar' => $comment->user->avatar,
                ];
                $formattedComments[] = $formattedComment;
            }

            // Obtener los propietarios del post
            $formattedUsers = [];

            $usersFromPost = $post->users;

            foreach ($usersFromPost as $user) {
                $formattedUser = [
                    'name' => $user->name,
                    'username' => $user->username,
                    'avatar' => $user->avatar,
                ];
                $formattedUsers[] = $formattedUser;
            }

            // Combinar los datos del post y los comentarios
            $data = [
                'post' => $postData,
                'users' => $formattedUsers,
                'comments' => $formattedComments
            ];

            return response()->json(['status' => true, 'data' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 404);
        }
    }

    /**
     * Actualiza la información de una publicación existente.
     *
     * Este método permite al usuario autenticado actualizar la información de una publicación existente
     * proporcionando los datos actualizados en la solicitud.
     *
     * @param  \App\Http\Requests\UpdatePostsRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Post actualizado",
     *     "data": {
     *         "post": {
     *             "image": "imagen_de_la_publicación",
     *             "title": "título_de_la_publicación",
     *             "description": "descripción_de_la_publicación",
     *             "post_type_name": "nombre_del_tipo_de_publicación",
     *             "start_date": "fecha_de_inicio_de_la_publicación",
     *             "end_date": "fecha_de_finalización_de_la_publicación",
     *             "active": true,
     *             "ubicacion": "ubicacion_de_la_publicación",
     *             "fecha_creacion": "fecha_de_creación_de_la_publicación",
     *             "hastags": ["hashtag1", "hashtag2", ...]
     *         },
     *         "users": [
     *             {
     *                 "name": "nombre_del_usuario",
     *                 "username": "nombre_de_usuario",
     *                 "avatar": "avatar_del_usuario",
     *                 "id": "ID_del_usuario"
     *             },
     *             ...
     *         ]
     *     }
     * }
     *
     * @response 403 {
     *     "status": false,
     *     "message": "Post no actualizado. No tienes permisos sobre este post."
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "message": "mensaje_de_error"
     * }
     */
    public function update(UpdatePostsRequest $request, string $id)
    {
        try {

            try {
                $id = Crypt::decryptString($id);
            } catch (DecryptException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Post inexistente',
                ], 500);
            }

            $user = Auth::user();
            $post = Post::find($id);
            $userVerificado = false;

            foreach ($post->users as $usuario) {
                if ($usuario->id == $user->id) {
                    $userVerificado = true;
                }
            }

            if ($userVerificado) {
                $post->update([
                    'image' => $request->image,
                    'title' => $request->title,
                    'description' => $request->description,
                    'post_type_id' => $request->post_type_id,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'ubicacion' => $request->ubicacion,
                    'active' => $request->active
                ]);

                //Obtener los datos del post
                $postData = [
                    'image' => $post->image,
                    'title' => $post->title,
                    'description' => $post->description,
                    'post_type_name' => optional($post->post_type)->name,
                    'start_date' => $post->start_date,
                    'end_date' => $post->end_date,
                    'active' => $post->active,
                    'ubicacion' => $post->ubicacion,
                    'fecha_creacion' => $post->created_at,
                    'hastags' => $post->hashtags->pluck('name')
                ];

                $formattedUsers = [];

                $usersFromPost = $post->users;

                foreach ($usersFromPost as $user) {
                    $formattedUser = [
                        'name' => $user->name,
                        'username' => $user->username,
                        'avatar' => $user->avatar,
                        'id' => $user->id
                    ];
                    $formattedUsers[] = $formattedUser;
                }
                $data = [
                    'post' => $postData,
                    'users' => $formattedUsers,
                ];

                //TODO Hacer que solo devuelva algunos datos del usuario
                return response()->json([
                    'status' => true,
                    'message' => 'Post actualizado',
                    'data' => $data
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Post no actualizado. No tienes permisos sobre este post.',
            ], 403);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Elimina una publicación existente de forma lógica.
     *
     * Este método permite al usuario autenticado eliminar una publicación existente de forma lógica,
     * marcándola como inactiva en lugar de eliminarla físicamente de la base de datos.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Post eliminado"
     * }
     *
     * @response 403 {
     *     "status": false,
     *     "message": "Post no eliminado. No tienes permisos sobre este post."
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "message": "mensaje_de_error"
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
                    'message' => 'Post inexistente',
                ], 500);
            }

            $user = Auth::user();
            $post = Post::find($id);
            $userVerificado = false;

            foreach ($post->users as $usuario) {
                if ($usuario->id == $user->id) {
                    $userVerificado = true;
                }
            }

            if ($userVerificado) {
                $post->update([
                    'active' => false,
                ]);

                $now = Carbon::now();
                $nowFormatted = $now->format('Y-m-d H:i:s');

                $postData = [
                    'id' => $post->id,
                    'username' => $user->username,
                    'image' => $post->image,
                    'title' => $post->title,
                    'description' => $post->description,
                    'post_type_id' => $post->post_type->id,
                    'start_date' => $post->start_date,
                    'end_date' => $post->end_date,
                    'ubicacion' => $post->ubicacion,
                    'hashtags' =>  "#" . implode('#', $post->hashtags->pluck('name')->toArray()),
                    'deleted_date' => $nowFormatted
                ];

                DB::table('deleted_posts')->insert($postData);

                $post->notifications()->delete();

                $post->delete();

                //TODO Hacer que solo devuelva algunos datos del usuario
                return response()->json([
                    'status' => true,
                    'message' => 'Post eliminado',
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Post no eliminado. No tienes permisos sobre este post.',
            ], 403);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }
}
