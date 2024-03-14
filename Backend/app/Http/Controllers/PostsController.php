<?php

namespace App\Http\Controllers;

use App\Events\ModelCreated;
use App\Http\Requests\StorePostsRequest;
use App\Http\Requests\UpdatePostsRequest;
use App\Http\Scripts\Utils;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\APIDocumentationController;
class PostsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/home_calendario",
     *     summary="Muestra una lista de publicaciones para el usuario sin ningún tipo de seguidos.",
     *     description="Este método devuelve una lista de publicaciones para el usuario autenticado sin restricciones.",
     *     operationId="getPublications",
     *     tags={"Posts"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="Lista de publicaciones para el usuario autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="post_id",
     *                         type="string",
     *                         description="ID de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="image",
     *                         type="string",
     *                         description="Imagen de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         description="Título de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         description="Descripción de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="Nombre del tipo de publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="start_date",
     *                         type="string",
     *                         description="Fecha de inicio de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="end_date",
     *                         type="string",
     *                         description="Fecha de finalización de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         description="Fecha de creación de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="username",
     *                         type="string",
     *                         description="Nombre de usuario"
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="string",
     *                         description="ID del usuario"
     *                     ),
     *                     @OA\Property(
     *                         property="avatar",
     *                         type="string",
     *                         description="Avatar del usuario"
     *                     ),
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron publicaciones para el usuario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Mensaje de error"
     *             )
     *         )
     *     )
     * )
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
                $post->post_id = Utils::Crypt($post->post_id);
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
     * @OA\Get(
     *     path="/home_todos",
     *     summary="Muestra una lista de publicaciones para el usuario sin ningún tipo de seguidos.",
     *     description="Este método devuelve una lista de publicaciones para el usuario autenticado sin restricciones.",
     *     operationId="getHomeTodos",
     *     tags={"Posts"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="Lista de publicaciones para el usuario autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="post_id",
     *                         type="string",
     *                         description="ID de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="image",
     *                         type="string",
     *                         description="Imagen de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         description="Título de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         description="Descripción de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="Nombre del tipo de publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="start_date",
     *                         type="string",
     *                         description="Fecha de inicio de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="end_date",
     *                         type="string",
     *                         description="Fecha de finalización de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         description="Fecha de creación de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="username",
     *                         type="string",
     *                         description="Nombre de usuario"
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="string",
     *                         description="ID del usuario"
     *                     ),
     *                     @OA\Property(
     *                         property="avatar",
     *                         type="string",
     *                         description="Avatar del usuario"
     *                     ),
     *                     @OA\Property(
     *                         property="comment_count",
     *                         type="integer",
     *                         description="Número de comentarios en la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="hashtags",
     *                         type="array",
     *                         @OA\Items(
     *                             type="string",
     *                             description="Nombre del hashtag"
     *                         ),
     *                         description="Lista de hashtags asociados a la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="userRol",
     *                         type="string",
     *                         description="Rol del usuario"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron publicaciones para el usuario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Mensaje de error"
     *             )
     *         )
     *     )
     * )
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
                $post->post_id = Utils::Crypt($post->post_id);
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
     *             "avatar": "avatar_del_usuario",
     *             "avg": "media_del_reseñas_del_usuario"
     *         },
     *         ...
     *     ]
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "message": "mensaje_de_error"
     * }
     * @OA\Get(
     *     path="/home",
     *     summary="Muestra una lista de publicaciones de los usuarios que sigue el usuario actual.",
     *     description="Este método devuelve una lista de publicaciones de los usuarios que sigue el usuario autenticado.",
     *     operationId="getHomePosts",
     *     tags={"Posts"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="Lista de publicaciones de los usuarios seguidos por el usuario autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="post_id",
     *                         type="string",
     *                         description="ID de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="image",
     *                         type="string",
     *                         description="Imagen de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         description="Título de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         description="Descripción de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="Nombre del tipo de publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="start_date",
     *                         type="string",
     *                         description="Fecha de inicio de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="end_date",
     *                         type="string",
     *                         description="Fecha de finalización de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         description="Fecha de creación de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="username",
     *                         type="string",
     *                         description="Nombre de usuario"
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="string",
     *                         description="ID del usuario"
     *                     ),
     *                     @OA\Property(
     *                         property="avatar",
     *                         type="string",
     *                         description="Avatar del usuario"
     *                     ),
     *                     @OA\Property(
     *                         property="comment_count",
     *                         type="integer",
     *                         description="Número de comentarios en la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="hashtags",
     *                         type="array",
     *                         @OA\Items(type="string"),
     *                         description="Lista de hashtags en la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="userRol",
     *                         type="string",
     *                         description="Rol del usuario"
     *                     ),
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron publicaciones de los usuarios seguidos por el usuario actual.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Mensaje de error"
     *             )
     *         )
     *     )
     * )
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
                    'commerces.avg as avg',
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
                $post->post_id = Utils::Crypt($post->post_id);
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
     * @OA\Post(
     *     path="/posts",
     *     summary="Crea una nueva publicación en la plataforma.",
     *     description="Este método permite al usuario autenticado crear una nueva publicación en la plataforma, con los datos proporcionados en la solicitud.",
     *     operationId="createPost",
     *     tags={"Posts"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos de la nueva publicación",
     *         @OA\JsonContent(ref="App\Http\Requests\StorePostsRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Publicación creada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post creado"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="post_id",
     *                     type="string",
     *                     description="ID de la publicación"
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     description="Imagen de la publicación"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     description="Título de la publicación"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="Descripción de la publicación"
     *                 ),
     *                 @OA\Property(
     *                     property="post_type_name",
     *                     type="string",
     *                     description="Nombre del tipo de publicación"
     *                 ),
     *                 @OA\Property(
     *                     property="start_date",
     *                     type="string",
     *                     description="Fecha de inicio de la publicación"
     *                 ),
     *                 @OA\Property(
     *                     property="end_date",
     *                     type="string",
     *                     description="Fecha de finalización de la publicación"
     *                 ),
     *                 @OA\Property(
     *                     property="active",
     *                     type="boolean",
     *                     description="Indica si la publicación está activa"
     *                 ),
     *                 @OA\Property(
     *                     property="ubicacion",
     *                     type="string",
     *                     description="Ubicación de la publicación"
     *                 ),
     *                 @OA\Property(
     *                     property="fecha_creacion",
     *                     type="string",
     *                     description="Fecha de creación de la publicación"
     *                 ),
     *                 @OA\Property(
     *                     property="hashtags",
     *                     type="array",
     *                     @OA\Items(type="string"),
     *                     description="Lista de hashtags en la publicación"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se pudo crear la publicación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Mensaje de error"
     *             )
     *         )
     *     )
     * )
     */

    public function store(StorePostsRequest $request)
    {
        try {

            $user = Auth::user();

            $rutaFotoPost = 'default';


            $post = Post::create([
                'image' => $rutaFotoPost,
                'title' => $request->title,
                'description' => $request->description,
                'post_type_id' => $request->post_type_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'active' => true,
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $rutaFotoPost = 'posts/' . $user->username.$post->id . '/imagenPost.webp';
                Storage::disk('public')->putFileAs('posts/'. $user->username, $image, '/imagenPost.webp');
                $rutaFotoPost = asset($rutaFotoPost);
            }

            $post->image=$rutaFotoPost;
            $post->save();
            
            try {
                $post->users()->attach($user->id);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage(),
                ], 404);
            }

            event(new ModelCreated($post));

            $postData = [
                'post_id' => $post->id = Utils::Crypt($post->id),
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
     * @OA\Get(
     *     path="/posts/{id}",
     *     summary="Muestra los detalles de una publicación específica junto con los comentarios y usuarios asociados.",
     *     description="Este método recupera información detallada sobre una publicación específica, incluyendo su imagen, título, descripción, tipo, fechas, estado, ubicación, fecha de creación y hashtags asociados. Además, obtiene hasta 5 comentarios asociados con la publicación, junto con los nombres de usuario, avatares e IDs de los comentaristas. También recupera información sobre los usuarios que son propietarios de la publicación, incluyendo sus nombres, nombres de usuario, avatares e IDs.",
     *     operationId="getPostDetails",
     *     tags={"Posts"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la publicación",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la publicación recuperados exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="post",
     *                     type="object",
     *                     @OA\Property(
     *                         property="image",
     *                         type="string",
     *                         description="Imagen de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         description="Título de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         description="Descripción de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="post_type_name",
     *                         type="string",
     *                         description="Nombre del tipo de publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="start_date",
     *                         type="string",
     *                         description="Fecha de inicio de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="end_date",
     *                         type="string",
     *                         description="Fecha de finalización de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="active",
     *                         type="boolean",
     *                         description="Indica si la publicación está activa"
     *                     ),
     *                     @OA\Property(
     *                         property="ubicacion",
     *                         type="string",
     *                         description="Ubicación de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="fecha_creacion",
     *                         type="string",
     *                         description="Fecha de creación de la publicación"
     *                     ),
     *                     @OA\Property(
     *                         property="hashtags",
     *                         type="array",
     *                         @OA\Items(type="string"),
     *                         description="Lista de hashtags en la publicación"
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="users",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             description="Nombre del usuario"
     *                         ),
     *                         @OA\Property(
     *                             property="username",
     *                             type="string",
     *                             description="Nombre de usuario"
     *                         ),
     *                         @OA\Property(
     *                             property="avatar",
     *                             type="string",
     *                             description="Avatar del usuario"
     *                         ),
     *                         @OA\Property(
     *                             property="id",
     *                             type="string",
     *                             description="ID del usuario"
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="comments",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="username",
     *                             type="string",
     *                             description="Nombre de usuario del comentario"
     *                         ),
     *                         @OA\Property(
     *                             property="content",
     *                             type="string",
     *                             description="Contenido del comentario"
     *                         ),
     *                         @OA\Property(
     *                             property="comment_id",
     *                             type="string",
     *                             description="ID del comentario"
     *                         ),
     *                         @OA\Property(
     *                             property="avatar",
     *                             type="string",
     *                             description="Avatar del usuario que comentó"
     *                         ),
     *                         @OA\Property(
     *                             property="user_id",
     *                             type="string",
     *                             description="ID del usuario que comentó"
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontró la publicación especificada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Mensaje de error"
     *             )
     *         )
     *     )
     * )
     */

    public function show(string $id)
    {
        try {

            $id = Utils::deCrypt($id);

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
            $comments = Comment::where('post_id', $id)->with('user')->take(10)->orderBy('created_at', 'desc')->get();

            // Formatear los datos de los comentarios
            $formattedComments = [];
            foreach ($comments as $comment) {
                $formattedComment = [
                    'username' => $comment->user->username,
                    'content' => $comment->content,
                    'comment_id' => Utils::Crypt($comment->id),
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
     * @OA\Put(
     *     path="/posts/{id}",
     *     summary="Actualiza la información de una publicación existente.",
     *     description="Este método permite al usuario autenticado actualizar la información de una publicación existente proporcionando los datos actualizados en la solicitud.",
     *     operationId="updatePost",
     *     tags={"Posts"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la publicación a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos actualizados de la publicación",
     *         @OA\JsonContent(ref="App\Http\Requests\UpdatePostsRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Publicación actualizada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post actualizado"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No tienes permisos sobre este post",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post no actualizado. No tienes permisos sobre este post."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mensaje de error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post no actualizado. No tienes permisos sobre este post."
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdatePostsRequest $request, string $id)
    {
        try {

            $id = Utils::deCrypt($id);
            $user = Auth::user();
            $post = Post::find($id);
            $userVerificado = false;

            foreach ($post->users as $usuario) {
                if ($usuario->id == $user->id) {
                    $userVerificado = true;
                }
            }

            if ($userVerificado) {

                $rutaFotoPost = $post->image;

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    Storage::disk('posts')->putFileAs($user->username, $image, '/imagenPost.webp'. $post->id);
                    $rutaFotoPost = env('APP_URL').Storage::url('posts/'.$user->username . '/imagenPost.webp'. $post->id);
                }

                if ($request->active) {
                    $post->active = $request->active;
                }

                $post->update([
                    'image' => $rutaFotoPost,
                    'title' => $request->title,
                    'description' => $request->description,
                    'post_type_id' => $request->post_type_id,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'ubicacion' => $request->ubicacion,
                    'active' => $post->active
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
     * @OA\Delete(
     *     path="/posts/{id}",
     *     summary="Elimina una publicación existente de forma lógica.",
     *     description="Este método permite al usuario autenticado eliminar una publicación existente de forma lógica, marcándola como inactiva en lugar de eliminarla físicamente de la base de datos.",
     *     operationId="deletePost",
     *     tags={"Posts"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la publicación a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Publicación eliminada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post eliminado"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No tienes permisos sobre este post",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post no eliminado. No tienes permisos sobre este post."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mensaje de error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Post no eliminado. No tienes permisos sobre este post."
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {

            $id = Utils::deCrypt($id);
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
                    'hashtags' => "#" . implode('#', $post->hashtags->pluck('name')->toArray()),
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
