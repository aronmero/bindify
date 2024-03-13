<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    /**
 * @swagger
 * /api/categorias:
 *   get:
 *     summary: Muestra una lista de todas las categorías.
 *     description: >
 *       Este método devuelve una lista de todas las categorías.
 *       Si se encuentran categorías, devuelve una respuesta JSON con los datos de las categorías y un estado 200.
 *       Si no se encuentran categorías, devuelve una respuesta JSON con un mensaje de error y un estado 404.
 *       Si ocurre algún otro error durante el proceso, devuelve una respuesta JSON con un mensaje de error y un estado 500.
 *     responses:
 *       200:
 *         description: Lista de categorías obtenida exitosamente.
 *         content:
 *           application/json:
 *             example:
 *               status: true
 *               data:
 *                 - name: NombreCategoría1
 *                 - name: NombreCategoría2
 *                 # ...
 *       404:
 *         description: No se encontraron categorías.
 *         content:
 *           application/json:
 *             example:
 *               status: false
 *               message: No se encontró ninguna categoría
 *       500:
 *         description: Error al obtener las categorías.
 *         content:
 *           application/json:
 *             example:
 *               status: false
 *               message: Hubo un problema al obtener las categorías: mensaje_de_error
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
