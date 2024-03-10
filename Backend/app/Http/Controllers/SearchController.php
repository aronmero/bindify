<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Hashtag;
use App\Models\Municipality;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Muestra una lista de comercios por municipio.
     *
     * Este método devuelve una lista de comercios para un municipio dado.
     *
     * @urlParam municipality string required El nombre del municipio.
     *
     * @response 200 {
     *     "status": true,
     *     "data": [
     *         {
     *             "email": "correo_electronico",
     *             "phone": "numero_de_telefono",
     *             "municipality_name": "nombre_del_municipio",
     *             "avatar": "avatar",
     *             "username": "nombre_de_usuario",
     *             "name": "nombre_del_comercio",
     *             "address": "disrección_del_comercio",
     *             "description": "descripción_del_comercio",
     *             "categories_name": "nombre_de_la_categoría",
     *             "schedule": "horario_del_comercio",
     *             "active": "activo_o_inactivo"
     *         },
     *         ...
     *     ]
     * }
     *
     * @response 404 (Dos Catch con el mismo codigo){
     *     "status": false,
     *     "error": "mensaje_de_error"
     * }
     */

    public function commerces(Request $request)
    {

        try {

            $commerces = Commerce::join('users', 'commerces.user_id', '=', 'users.id')
            ->join('categories', 'commerces.category_id', '=', 'categories.id')
            ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
            ->leftjoin('reviews', 'commerces.user_id', '=', 'reviews.commerce_id')
            ->select(
                'commerces.user_id',
                'email',
                'phone',
                'avatar',
                'users.username',
                'address',
                'commerces.description',
                'categories.name AS categories_name',
                'schedule',
                'commerces.avg',
                DB::raw('count(reviews.commerce_id) as review_count')
            )
            ->where('commerces.active','=', '1')
            ->groupBy('commerces.user_id','email', 'phone', 'avatar', 'users.username', 'address', 'commerces.description', 'categories_name', 'schedule', 'commerces.avg',);

            if($request->municipality) {
                Municipality::where('name', $request->municipality)->firstOrFail();
                $commerces = $commerces->where('municipalities.name', '=', $request->municipality);
            }

            if($request->name) {
                $commerces = $commerces->where('users.username', 'LIKE', $request->name . '%');
            }

            if($request->category) {
                $commerces = $commerces->where('categories.name', '=', $request->category);
            }

            $commerces = $commerces->get();

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

    public function posts(Request $request)
    {

        try {

            $posts = Post::join('post_types', 'post_types.id', '=', 'posts.post_type_id')
            ->join('users-posts', 'users-posts.post_id', '=', 'posts.id')
            ->join('users', 'users.id', '=', 'users-posts.user_id')
            ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
            ->select(
                'users.avatar',
                'users.username',
                'users.name',
                'posts.image',
                'posts.title',
                'posts.description',
                'post_types.name AS post_type',
            );

            if($request->municipality) {
                Municipality::where('name', $request->municipality)->firstOrFail();
                $posts = $posts->where('municipalities.name', '=', $request->municipality);
            }

            if($request->post_type) {
                $posts = $posts->where('post_types.name', '=', $request->post_type);
            }

            $posts = $posts->get();

            return response()->json([
                "status" => true,
                "data" => $posts
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
