<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CommercesController extends Controller
{
    public function __construct() {
        $this->middleware("can:ver commerce")->only("show");
        $this->middleware("can:editar commerce")->only("store", "update");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'municipality_id' => $request->municipality_id,
                'avatar' => $request->avatar,
                'username' => $request->username,
                'nombre' => $request->nombre
            ]);

            $commerce = Commerce::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'description' => $request->description,
                'verification_token_id' => $request->verification_token_id,
                'category_id' => $request->category_id,
                'verificated' => $request->verificated,
                'schedule' => $request->schedule
            ]);


            return response()->json([
                'status' => true,
                'message' => 'Comercio creado',
                'data' => $commerce
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage(), 
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $data = DB::table('commerces')
            ->join('users', 'commerces.user_id', '=', 'users.id')
            ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
            ->join('categories', 'commerces.category_id', '=', 'categories.id')
            ->select('email', 'phone', 'municipalities.name AS municipality_name', 'avatar', 'username', 'nombre',
             'address', 'description', 'categories.name AS categories_name', 'schedule', 'active')
            ->where('users.id', '=', $id)
            ->get();

            return response()->json([
                'status' => true,
                'data' => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => throw $th,
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            $user = User::find($id);
            $user->update($request->all());

            $commerce = Commerce::find($id);
            $commerce->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'comercio actualizado',
                'data' => $commerce
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => throw $th->getMessage(),
            ], 404);
        }
        
    }
}
