<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoriesController extends Controller

{
    //Devuelve Un array JSON de todas las categorías con los siguientes datos
    public function index()
    {
        try {
            $categorias = Category::all();
            return response()->json(['status' => true, $categorias, 200]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false,'message' => 'No se encontró ninguna categoría'], 404);
        } catch (Exception $e) {
            return response()->json(['status' => false,'message' => 'Hubo un problema al obtener las categorías: ' . $e->getMessage()], 500);
        }
    }
}
