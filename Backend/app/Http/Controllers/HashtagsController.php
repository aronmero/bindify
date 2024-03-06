<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;

class HashtagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:ver hashtag')->only('index');
        $this->middleware('can:editar hashtag')->only('index', 'store', 'update', 'destroy');

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $data = Hashtag::all();

            return response()->json([
                'status' => false,
                'data'=> $data 
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=> $th->getMessage(), 
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = Hashtag::create($request->all());

            return response()->json([
                'status' => false,
                'data'=> $data->id 
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=> $th->getMessage(), 
            ], 404);
        }
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
