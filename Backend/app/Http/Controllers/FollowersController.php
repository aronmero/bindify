<?php

namespace App\Http\Controllers;

use App\Events\ModelCreated;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\APIDocumentationController;

class FollowersController extends Controller
{
    /**
     * @OA\Get(
     *     path="/follower",
     *     summary="Muestra los seguidores del usuario autenticado.",
     *     description="Este método devuelve una lista de los seguidores del usuario autenticado.",
     *     tags={"Followers"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="Lista de seguidores obtenida exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="follower_id", type="string", example="ID_del_seguidor"),
     *                 @OA\Property(property="avatar", type="string", example="avatar_del_seguidor"),
     *                 @OA\Property(property="username", type="string", example="nombre_de_usuario_del_seguidor")
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Error al obtener los seguidores.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="mensaje_de_error")
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/follow/{username}",
     *     summary="Sigue o deja de seguir a un usuario.",
     *     description="Este método permite al usuario autenticado seguir o dejar de seguir a otro usuario especificado por su username.",
     *     tags={"Followers"},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="El username del usuario a seguir o dejar de seguir.",
     *         @OA\Schema(type="string")
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="El usuario ha sido seguido o dejado de seguir exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="mensaje_de_confirmación")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Error al seguir o dejar de seguir al usuario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="mensaje_de_error")
     *         )
     *     )
     * )
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

                $seguido = Follower::where("follower_id", $user->id)->where('follows_id', $usuarioSeguir->id)->first();

                event(new ModelCreated($seguido));

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
     * @OA\Get(
     *     path="/follows",
     *     summary="Muestra a los usuarios seguidos por el usuario autenticado.",
     *     description="Este método devuelve una lista de usuarios que son seguidos por el usuario autenticado.",
     *     tags={"Followers"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios seguidos obtenida exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="follows_id", type="string", example="ID_del_usuario_seguido"),
     *                     @OA\Property(property="avatar", type="string", example="avatar"),
     *                     @OA\Property(property="username", type="string", example="nombre_de_usuario")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Error al obtener la lista de usuarios seguidos.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="mensaje_de_error")
     *         )
     *     )
     * )
     */
    public function showFollows()
    {
        try {
            $user = Auth::user();

            $follows = DB::table("followers")
                ->join('users', 'followers.follows_id', '=', 'users.id')
                ->select('followers.follows_id', 'followers.favorito', 'avatar', 'username')
                ->where('followers.follower_id', '=', $user->id)
                ->get();

            $follows->each(function ($follow) {
                $follow->favorito = ($follow->favorito == 1) ? true : false;
            });

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
     * @OA\Post(
     *     path="/favorite/{username}",
     *     summary="Añade como favorito a un usuario seguido.",
     *     description="Este método permite al usuario autenticado seguir o dejar de seguir a otro usuario especificado por su username.",
     *     tags={"Followers"},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         description="El username del usuario a seguir o dejar de seguir.",
     *         @OA\Schema(type="string")
     *     ),
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="Usuario añadido o eliminado de favoritos exitosamente.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="mensaje_de_confirmación")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Error al encontrar al usuario o al procesar la solicitud.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="mensaje_de_error")
     *         )
     *     )
     * )
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
