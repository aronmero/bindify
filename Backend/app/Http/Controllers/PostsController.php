<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{

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

            $listado = DB::table("posts")
                ->join('users-posts', 'users-posts.post_id', '=', 'posts.id')
                ->join('users', 'users.id', '=', 'users-posts.user_id')
                ->join('post_types', 'post_types.id', '=', 'posts.post_type_id')
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
                    'users.avatar'
                )
                ->whereIn('users-posts.user_id', $ids)
                ->where('posts.active', '=', true)
                ->orderBy('posts.created_at','desc')
                ->get();

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

            return response()->json([
                'status' => true,
                'message' => 'Post creado',
                'data' => $post
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            
            $post = Post::find($id);

            $data = [
                'image' => $post->image,
                'title' => $post->title,
                'description' => $post->description,
                'post_type_name' => $post->post_type->name,
                'start_date' => $post->start_date,
                'end_date' => $post->end_date,
                'active' => $post->active,
            ];


            return response()->json([
                'status' => true,
                'data' => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
