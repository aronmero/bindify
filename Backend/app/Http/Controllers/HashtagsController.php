<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;

class HashtagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:ver hashtag')->only('index');
        $this->middleware('can:editar hashtag')->only('index', 'store');

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $data = Hashtag::all();

            return response()->json([
                'status' => true,
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
                'status' => true,
                'data'=> $data->id 
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=> $th->getMessage(), 
            ], 404);
        }
    }
}
