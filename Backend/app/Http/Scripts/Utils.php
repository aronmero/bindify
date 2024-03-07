<?php

namespace App\Http\Scripts;

use App\Models\Hashtag;

class Utils
{


  // public static example() {

  // }



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
      array_push($hashtagsOutput,$existingHashtag->id);

    }

    // Devuelve el array de hashtags
    return $hashtagsOutput;
  }
}
