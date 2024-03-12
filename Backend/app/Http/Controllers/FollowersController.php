<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * Este método permite al usuario autenticado seguir o dejar de seguir a otro usuario especificado por su username.
     *
     * @urlParam username string required El username del usuario a seguir o dejar de seguir.
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

    public function follow(string $username)
    {
        try {

            $usuarioSeguir = User::where('username', $username)->firstOrFail();

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
                    if ($seguido->follows_id == $usuarioSeguir->id) {
                        $seguir = false;
                    }
                }
            }


            if (!$seguir) {
                $user->follows()->detach($usuarioSeguir->id);
                $mensaje = "Usuario dejado de seguir";
            } else {
                $user->follows()->attach($usuarioSeguir->id);
                $mensaje = "Usuario seguido";
            }


            return response()->json([
                'status' => true,
                'message' => $mensaje,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
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

    /**
     * Añade como favorito a un usuario seguido.
     *
     * Este método permite al usuario autenticado seguir o dejar de seguir a otro usuario especificado por su username.
     *
     * @urlParam username string required El username del usuario a seguir o dejar de seguir.
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
    public function favorite(string $username)
    {
        try {

            $auth = Auth::user();
            $userId = User::where('username', $username)->firstOrFail()->id;

            //Comprobar que sigues al usuario
            try {
                $seguido = $auth->follows()->where('follows_id', '=', $userId)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Usuario no seguido'
                ], 403);
            }

            $favorite = Follower::where('follows_id', $userId)->where('follower_id', $auth->id)->first()->favorito;

            if ($favorite) {
                Follower::where('follows_id', $userId)->where('follower_id', $auth->id)->update(['favorito' => false]);
                return response()->json([
                    'status' => true,
                    'message' => 'Usuario eliminado de favoritos',
                ], 200);
            }

            Follower::where('follows_id', $userId)->where('follower_id', $auth->id)->update(['favorito' => true]);
            return response()->json([
                'status' => true,
                'message' => 'Usuario añadido a favoritos',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => throw $th
            ], 404);
        }
    }
}
