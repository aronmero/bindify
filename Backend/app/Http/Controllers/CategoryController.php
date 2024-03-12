<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    /**
     * Muestra una lista de todas las categorías.
     *
     * Este método devuelve una lista de todas las categorías.
     * Si se encuentran categorías, devuelve una respuesta JSON con los datos de las categorías y un estado 200.
     * Si no se encuentran categorías, devuelve una respuesta JSON con un mensaje de error y un estado 404.
     * Si ocurre algún otro error durante el proceso, devuelve una respuesta JSON con un mensaje de error y un estado 500.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON que contiene los datos de las categorías o un mensaje de error.
     *
     * @response 200 {
     *   "status": true,
     *   "data": [
     *     {
     *       // Datos de la categoría 1
     *     },
     *     {
     *       // Datos de la categoría 2
     *     },
     *     // ...
     *   ]
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "message": "No se encontró ninguna categoría"
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "Hubo un problema al obtener las categorías: mensaje_de_error"
     * }
     */
    public function index()
    {
        try {
            // Obtener todas las categorías
            $categorias = Category::select('name')->get();

            // Devolver una respuesta con los datos de las categorías
            return response()->json(['status' => true, 'data' => $categorias], 200);
        } catch (ModelNotFoundException $e) {
            // Manejar el caso en el que no se encuentren categorías
            return response()->json(['status' => false, 'message' => 'No se encontró ninguna categoría'], 404);
        } catch (Exception $e) {
            // Manejar cualquier otro error
            return response()->json(['status' => false, 'message' => 'Hubo un problema al obtener las categorías: ' . $e->getMessage()], 500);
        }
    }
}
