<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class MunicipalitiesController extends Controller
{
    /**
     * Muestra una lista de los recursos.
     *
     * Este método devuelve una lista de todos los municipios.
     * Si se encuentran municipios, devuelve una respuesta JSON con los datos de los municipios y un estado 200.
     * Si no se encuentran municipios, devuelve una respuesta JSON con un mensaje de error y un estado 404.
     * Si ocurre algún otro error durante el proceso, devuelve una respuesta JSON con un mensaje de error y un estado 500.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta JSON que contiene los datos de los municipios o un mensaje de error.
     *
     * @response 200 {
     *   "status": true,
     *   "data": [
     *     {
     *       // Datos del municipio 1
     *     },
     *     {
     *       // Datos del municipio 2
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
            // Obtener todos los municipios
            $municipalities = Municipality::select('name','id')->get();

            // Devolver una respuesta con los datos de los municipios
            return response()->json(['status' => true, 'data' => $municipalities], 200);
        } catch (ModelNotFoundException $e) {
            // Manejar el caso en el que no se encuentren municipios
            return response()->json(['status' => false, 'message' => 'No se encontró ningun municipio'], 404);
        } catch (Exception $e) {
            // Manejar cualquier otro error
            return response()->json(['status' => false, 'message' => 'Hubo un problema al obtener los municipios: ' . $e->getMessage()], 500);
        }
    }
}
