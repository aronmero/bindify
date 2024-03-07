<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowersController extends Controller
{


    /**
     * Muestra todos los seguidores del usuario
     */
    public function showFollowers()
    {
        try {          
            $user = Auth::user();

            $followers = DB::table("followers")
            ->join('users', 'followers.follows_id', '=','users.id')
            ->select('users.id', 'avatar', 'username')
            ->where('followers.follower_id', '=', $user->id)
            ->get();

            return response()->json([
                'status' => true,
                'data'=> $followers
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=> throw $th,
            ], 404);
        }
    }

    /**
     * Comienza a seguir a un usuario, en caso de ya seguir al usuario dejara de seguirlo
     */
    public function follow(string $id)
    {
        try {

            $user = Auth::user();
            $mensaje = "";
            $follower = $user->follows();
            
            foreach ($follower as $seguido) {
                if ($seguido->id == $id) {
                    $user->follows()->detach($id);
                    $mensaje = "Usuario dejado de seguir";
                }else {
                    $user->follows()->attach($id);
                    $mensaje = "Usuario seguido";
                }
            }
            
            return response()->json([
                'status' => true,
                'message' => $mensaje,
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=> $th->getMessage()
            ], 404);
        }
    }


    /**
     * Muestra todos los seguidos del usuario
     */
    public function showFollows(string $id)
    {
        try {
            $user = Auth::user();

            $follows = DB::table("followers")
            ->join('users', 'followers.follows_id', '=','users.id')
            ->select('users.id', 'avatar', 'username')
            ->where('followers.followers_id', '=', $user->id)
            ->get();

            return response()->json([
                'status' => true,
                'data'=> $follows
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=> $th->getMessage()
            ], 404);
        }
    }

}
