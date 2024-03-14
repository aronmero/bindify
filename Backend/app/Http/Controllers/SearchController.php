<?php

namespace App\Http\Controllers;

use App\Http\Scripts\Utils;
use App\Models\Commerce;
use App\Models\Municipality;
use App\Models\Post;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    /**
     * Muestra una lista de publicaciones por municipio.
     *
     * Este método devuelve una lista de publicaciones asociadas a un municipio dado.
     *
     * @urlParam municipality string required El nombre del municipio.
     *
     * @response 200 {
     *     "status": true,
     *     "data": [
     *         {
     *             "avatar": "avatar_del_usuario",
     *             "username": "nombre_de_usuario",
     *             "name": "nombre_del_usuario",
     *             "image": "imagen_de_la_publicación",
     *             "title": "título_de_la_publicación",
     *             "description": "descripción_de_la_publicación",
     *             "name": "nombre_del_tipo_de_publicación",
     *             "active": "activo_o_inactivo"
     *         },
     *         ...
     *     ]
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "error": "mensaje_de_error"
     * }
     */

    public function search(Request $request)
    {
        try {

            if ($request->type == 'Posts') {
                $posts = Post::leftJoin('posts-hashtags', 'posts-hashtags.post_id', '=', 'posts.id')
                    ->leftJoin('hashtags', 'posts-hashtags.hashtag_id', '=', 'hashtags.id')
                    ->join('users-posts', 'users-posts.post_id', '=', 'posts.id')
                    ->join('users', 'users.id', '=', 'users-posts.user_id')
                    ->join('commerces', 'commerces.user_id', '=', 'users.id')
                    ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                    ->join('post_types', 'post_types.id', '=', 'posts.post_type_id')
                    ->select(
                        'users.avatar',
                        'users.username',
                        'users.name',
                        'posts.id as post_id',
                        'posts.image',
                        'posts.title',
                        'posts.description',
                        'post_types.name AS post_type',
                        'posts.start_date as publicated_date',
                        'commerces.avg'
                    )
                    ->where('commerces.active', '=', true)
                    ->where('posts.active', '=', true)
                    ->orderBy('posts.start_date', 'desc')
                    ->distinct();

                if ($request->municipality) {
                    Municipality::where('name', $request->municipality)->firstOrFail();
                    $posts = $posts->where('municipalities.name', '=', $request->municipality);
                }

                if ($request->post_type) {
                    $posts = $posts->where('post_types.name', '=', $request->post_type);
                }

                if ($request->name) {
                    $posts = $posts->where('posts.title', 'LIKE', $request->name . '%');
                }

                if ($request->hashtag) {
                    $posts = $posts->where('hashtags.name', '=', $request->hashtag);
                }

                $posts = $posts->get();

                $posts->each(function ($post) {
                    $post->hashtags = Post::find($post->post_id)->hashtags->pluck('name')->toArray();
                    $post->post_id = Utils::Crypt($post->post_id);
                    $user = User::where('username', $post->username)->first();
                    $post->userRol = $user->getRoleNames()[0];
                });

                return response()->json([
                    "status" => true,
                    "data" => $posts
                ], 200);
            }

            $commerces = Commerce::leftjoin('reviews', 'commerces.user_id', '=', 'reviews.commerce_id')
                ->leftJoin('commerces-hashtags', 'commerces-hashtags.commerce_id', '=', 'commerces.user_id')
                ->leftJoin('hashtags', 'commerces-hashtags.hashtag_id', '=', 'hashtags.id')
                ->join('users', 'commerces.user_id', '=', 'users.id')
                ->join('categories', 'commerces.category_id', '=', 'categories.id')
                ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                ->select(
                    'commerces.user_id',
                    'email',
                    'phone',
                    'avatar',
                    'users.username',
                    'address',
                    'municipalities.name as municipality_name',
                    'commerces.description',
                    'categories.name AS categories_name',
                    'schedule',
                    'commerces.avg',
                )
                ->where('commerces.active', '=', true)
                ->distinct()
                ->groupBy('commerces.user_id', 'email', 'phone', 'avatar', 'users.username', 'address', 'commerces.description', 'categories_name', 'schedule', 'commerces.avg', 'municipality_name');

            if ($request->municipality) {
                Municipality::where('name', $request->municipality)->firstOrFail();
                $commerces = $commerces->where('municipalities.name', '=', $request->municipality);
            }

            if ($request->name) {
                $commerces = $commerces->where('users.username', 'LIKE', $request->name . '%');
            }

            if ($request->category) {
                $commerces = $commerces->where('categories.name', '=', $request->category);
            }

            if ($request->hashtag) {
                $commerces = $commerces->where('hashtags.name', '=', $request->hashtag);
            }

            $commerces = $commerces->get();

            $commerces->each(function ($commerce) {
                $commerce->hashtags = Commerce::find($commerce->user_id)->hashtags->pluck('name')->toArray();
                $commerce->review_count = Review::where('commerce_id', $commerce->user_id)->count();
                unset($commerce->user_id);
                $user = User::where('username', $commerce->username)->first();
                $commerce->userRol = $user->getRoleNames()[0];
            });

            return response()->json([
                "status" => true,
                "data" => $commerces
            ], 200);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                "status" => false,
                "error" => "Municipio $request->municipality no encontrado",
            ], 404);
        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 404);
        }
    }
}
