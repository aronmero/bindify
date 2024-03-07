<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Hashtag;
use App\Models\Municipality;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function commercesByMunicipality(string $municipality)
    {

        try {

            Municipality::where('name', $municipality)->firstOrFail();

            $commerces = Commerce::join('users', 'commerces.user_id', '=', 'users.id')
            ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
            ->join('categories', 'commerces.category_id', '=', 'categories.id')
            ->select('email', 'phone', 'municipalities.name AS municipality_name', 'avatar', 'username', 'users.name',
             'address', 'commerces.description', 'categories.name AS categories_name', 'schedule', 'commerces.active')
            ->where('municipalities.name', '=', $municipality)
            ->get();

            return response()->json([
                "status" => true,
                "data" => $commerces
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                "status" => false,
                "error" => "Municipio $municipality no encontrado",
            ], 404);

        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 404);
        }

    }

    public function commercesByHashtag(string $hashtag)
    {

        try {

            $hashtag = Hashtag::where('name', $hashtag)->firstOrFail();

            $commerces = $hashtag->commerces->map(function ($commerce) {
                return [
                    'user_id' => $commerce->user_id,
                    'address' => $commerce->address,
                    'description' => $commerce->description,
                    'verification_token_id' => $commerce->verification_token_id,
                    'category_id' => $commerce->category_id,
                    'verificated' => $commerce->verificated,
                    'schedule' => $commerce->schedule,
                    'avg' => $commerce->avg,
                    'active' => $commerce->active,
                ];
            });

            return response()->json([
                "status" => true,
                "data" => $commerces
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                "status" => false,
                "error" => "Hashtag $hashtag no encontrado",
            ], 404);

        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 404);
        }

    }

    public function postsByMunicipality(string $municipality)
    {

        try {

            Municipality::where('name', $municipality)->firstOrFail();

            $posts = Post::join('post_types', 'post_types.id', '=', 'posts.post_type_id')
            ->join('users-posts', 'users-posts.post_id', '=', 'posts.id')
            ->join('users', 'users.id', '=', 'users-posts.user_id')
            ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
            ->select('users.avatar', 'users.username', 'users.name', 'posts.image', 'posts.title', 'posts.description', 'post_types.name', 'posts.active',)
            ->where('municipalities.name', '=', $municipality)
            ->get();

            return response()->json([
                "status" => true,
                "data" => $posts
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                "status" => false,
                "error" => "Municipio $municipality no encontrado",
            ], 404);

        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 404);
        }

    }

    public function postsByHashtag(string $hashtag)
    {

        try {

            $hashtag = Hashtag::where('name', $hashtag)->firstOrFail();

            $posts = $hashtag->posts->map(function ($post) {
                return [
                    'image' => $post->image,
                    'title' => $post->title,
                    'description' => $post->description,
                    'post_type_id' => $post->post_type_id,
                    'schedule' => $post->schedule,
                    'active' => $post->active,
                ];
            });

            return response()->json([
                "status" => true,
                "data" => $posts
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                "status" => false,
                "error" => "Hashtag $hashtag no encontrado",
            ], 404);

        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 404);
        }

    }
}
