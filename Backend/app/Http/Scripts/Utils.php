<?php

namespace App\Http\Scripts;

use App\Models\Hashtag;
use App\Models\Review;
use App\Models\Commerce;

class Utils
{
    // Metodo de encriptado
    protected static $method = 'AES-256-CBC';
    // IV (vector de inicialización) para encriptar
    protected static $iv = 1234567890123456;

    /**
     * Extrae hashtags de una cadena de texto y los agrega a la base de datos si no existen.
     *
     * Esta función busca hashtags en una cadena de texto utilizando una expresión regular.
     * Luego, verifica si cada hashtag encontrado ya existe en la base de datos.
     * Si un hashtag no existe, lo inserta en la base de datos.
     *
     * @param string $frase - La cadena de texto de la cual extraer los hashtags.
     *
     * @return array - Array que contiene los hashtags extraídos y/o insertados en la base de datos.
     */
    public static function GetHashtag(String $frase)
    {
        $hashtags = []; // Inicializa un array para almacenar los hashtags encontrados en la frase

        // Utiliza una expresión regular para buscar los hashtags en la cadena de texto
        preg_match_all('/#(\w+)/', $frase, $matches);

        // Recorre los resultados encontrados por la expresión regular
        foreach ($matches[1] as $match) {
            // Agrega el hashtag encontrado al array de hashtags

            $hashtags[] = $match;
        }
        //Array que devolvemos con el id de los hastag creados o detectados
        $hashtagsOutput = [];
        // Verifica cada hashtag encontrado
        foreach ($hashtags as $hashtag) {
            // Busca el hashtag en la base de datos
            $existingHashtag = Hashtag::where('name', $hashtag)->first();

            // Si el hashtag no existe en la base de datos lo inserta
            if (!$existingHashtag) {
                $existingHashtag = new Hashtag();
                $existingHashtag->name = $hashtag;
                $existingHashtag->id = $hashtag;
                $existingHashtag->save();
            }
            array_push($hashtagsOutput, $existingHashtag->id);
        }

        // Devuelve el array de hashtags
        return $hashtagsOutput;
    }


    /**
     * Funcion que busca por parametro el id del comercio y devuelve la media de la puntuacion de sus reviews
     * EN DES-USO , NO ESTA INTEGRADO
     *
     * Esta función busca por el id del comercio  las reviews y calcula
     * la media de todas las puntuaciones que tenga en la tabla reviews con el id de ese comercio
     * ademas inserta en el comercio la media de sus puntuaciones en la tabla avg
     *
     *
     * @param string $id - ID del comercio a calcular la puntuacion media
     *
     * @return double - $averageScore - puntuacion media del comercio
     *
     * @response 404 {
     *   "status": false,
     *   "message": "no existen reviews para este comercio"
     *  }
     * @response 500 {
     *   "status": false,
     *   "message": "Error al insertar la puntuación media en la tabla de comercios"
     * }
     */
    public static function AVG_Reviews(int $id)
    {
        // Obtener todas las reviews por el ID del comercio
        $reviews = Review::where('commerce_id', $id)->get();

        //Comprueba si existen reviews para ese comercio
        if ($reviews->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No existen reviews para este comercio'], 404);
        }

        //Suma y almacena en una variable la puntuacion total de todas las reviews
        $totalScore = $reviews->sum('note');

        // Calcula la media total de todas las puntuaciones de las reviews de ese comercio
        $averageScore = $totalScore / $reviews->count();

        // Insertar la puntuación media en la tabla de comercios
        try {
            // Encuentra el comercio por su ID
            $commerce = Commerce::where('user_id', $id)->first();

            // Verifica si el comercio existe
            if (!$commerce) {
                return response()->json(['status' => false, 'message' => 'El comercio no existe'], 404);
            }

            // Actualiza el campo avg con la puntuación media
            $commerce->avg = $averageScore;

            // Guarda los cambios en la base de datos
            $commerce->save();

            return response()->json(['status' => true, 'message' => 'Media calculada e insertada en el comercio con el id:' . $id . " con una puntuacion media de :" . $averageScore], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error al insertar la puntuación media en la tabla de comercios'], 500);
        }
    }

    /**
     * Función que encripta un ID de elemento.
     *
     * Esta función toma un ID de elemento como entrada, lo encripta utilizando AES-256-CBC
     * con una clave secreta y un IV fijo, y luego devuelve
     * la ID encriptada sin los dos últimos caracteres.
     *
     * @param string $id - ID del elemento a encriptar
     *
     * @return string - ID del elemento encriptada
     */
    public static function Crypt(string $id)
    {
        $encrypted = openssl_encrypt($id, self::$method, env('SECRET_KEY'), 0, self::$iv);
        $encrypted = substr($encrypted, 0, -2);
        $encrypted = str_replace('/', '_', $encrypted);
        return $encrypted;
    }

    /**
     * Función que desencripta un ID de elemento encriptado.
     *
     * Esta función toma un ID de elemento encriptado como entrada, lo desencripta
     * utilizando AES-256-CBC con la clave secreta y el IV fijo,
     * y luego devuelve la ID desencriptada.
     *
     * @param string $id - ID del elemento encriptada
     *
     * @return string - ID del elemento desencriptada
     */
    public static function deCrypt(string $id)
    {
        $id = str_replace('_', '/', $id);
        $decrypted = openssl_decrypt($id . "==", self::$method, env('SECRET_KEY'), 0, self::$iv);
        return $decrypted;
    }
}
