<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{

    /**
     * Devuelve en listado de posts de empresas que sigue el usuario
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
                        'posts.id AS post_id','posts.image', 'posts.title','posts.description','posts.description','post_types.name','posts.start_date','posts.end_date',
                        'posts.created_at','users.username', 'users.id AS user_id', 'users.avatar'
                    )
                    ->whereIn('users-posts.user_id', $ids)
                    ->where('posts.active', '=', true)
                    ->get();
            

            $posts = $listado;

            return response()->json([
                'status' => true,
                'data' => $posts,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => throw $th,
            ], 404);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
