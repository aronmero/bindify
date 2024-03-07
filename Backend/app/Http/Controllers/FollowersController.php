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
    public function showFollowers(string $id)
    {
        try {
            $followers = DB::table("followers")
            ->join('users', 'followers.follows_id', '=','users.id')
            ->select('users.id', 'avatar', 'username')
            ->where('followers.follows_id', '=', $id)
            ->get();

            return response()->json([
                'status' => true,
                'data'=> $followers
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=> $th->getMessage()
            ], 404);
        }
    }

    /**
     * 
     */
    public function follow(string $id)
    {
        try {

            $user = Auth::user();

            if (condition) {
                # code...
            }
            
            $user->follow()->attach($id);

            return response()->json([
                'status' => true,
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=> $th->getMessage()
            ], 404);
        }
    }

}
