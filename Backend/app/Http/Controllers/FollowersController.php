<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowersController extends Controller
{


    /**
     * Muestra los seguidores del usuario autenticado.
     *
     * Este método devuelve una lista de los seguidores del usuario autenticado.
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": true,
     *     "data": [
     *         {
     *             "follower_id": "ID_del_seguidor",
     *             "avatar": "avatar_del_seguidor",
     *             "username": "nombre_de_usuario_del_seguidor"
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

    public function showFollowers()
    {
        try {
            $user = Auth::user();

            $followers = DB::table("followers")
                ->join('users', 'followers.follower_id', '=', 'users.id')
                ->select('follower_id', 'avatar', 'username')
                ->where('followers.follows_id', '=', $user->id)
                ->get();

            return response()->json([
                'status' => true,
                'data' => $followers
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 404);
        }
    }

    /**
     * Sigue o deja de seguir a un usuario.
     *
     * Este método permite al usuario autenticado seguir o dejar de seguir a otro usuario especificado por su ID.
     *
     * @urlParam id string required El ID del usuario a seguir o dejar de seguir.
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": true,
     *     "message": "mensaje_de_confirmación"
     * }
     *
     * @response 404 {
     *     "status": false,
     *     "message": "mensaje_de_error"
     * }
     */

    public function follow(string $id)
    {
        try {
            $user = Auth::user();
            $mensaje = "";
            $follows = DB::table("followers")
                ->join('users', 'followers.follows_id', '=', 'users.id')
                ->select('followers.follows_id', 'avatar', 'username')
                ->where('followers.follower_id', '=', $user->id)
                ->get();
            $seguir = true;

            if ($follows->count() > 0) {
                foreach ($follows as $seguido) {
                    if ($seguido->follows_id == $id) {
                        $seguir = false;
                    }
                }
            }


            if (!$seguir) {
                $user->follows()->detach($id);
                $mensaje = "Usuario dejado de seguir";
            } else {
                $user->follows()->attach($id);
                $mensaje = "Usuario seguido";
            }


            return response()->json([
                'status' => true,
                'message' => $mensaje,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => throw $th
            ], 404);
        }
    }


    /**
     * Muestra a los usuarios seguidos por el usuario autenticado.
     *
     * Este método devuelve una lista de usuarios que son seguidos por el usuario autenticado.
     *
     * @authenticated
     *
     * @response 200 {
     *     "status": true,
     *     "data": [
     *         {
     *             "follows_id": "ID_del_usuario_seguido",
     *             "avatar": "avatar",
     *             "username": "nombre_de_usuario"
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

    public function showFollows()
    {
        try {
            $user = Auth::user();

            $follows = DB::table("followers")
                ->join('users', 'followers.follows_id', '=', 'users.id')
                ->select('followers.follows_id', 'avatar', 'username')
                ->where('followers.follower_id', '=', $user->id)
                ->get();

            return response()->json([
                'status' => true,
                'data' => $follows
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 404);
        }
    }

}
