<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use App\Http\Controllers\APIDocumentationController;

class MunicipalitiesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/municipality",
     *     summary="Muestra una lista de los municipios.",
     *     description="Este método devuelve una lista de todos los municipios. Si se encuentran municipios, devuelve una respuesta JSON con los datos de los municipios y un estado 200. Si no se encuentran municipios, devuelve una respuesta JSON con un mensaje de error y un estado 404. Si ocurre algún otro error durante el proceso, devuelve una respuesta JSON con un mensaje de error y un estado 500.",
     *     operationId="getMunicipalities",
     *     tags={"Municipalities"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de municipios recuperada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="Nombre del municipio"
     *                     ),
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontró ninguna categoría",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="No se encontró ninguna categoría"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Hubo un problema al obtener las categorías",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Hubo un problema al obtener los municipios: mensaje_de_error"
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            // Obtener todos los municipios
            $municipalities = Municipality::select('name')->get();

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
